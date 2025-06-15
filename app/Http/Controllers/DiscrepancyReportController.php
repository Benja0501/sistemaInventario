<?php

namespace App\Http\Controllers;

use App\Models\DiscrepancyReport;
use App\Http\Requests\StoreDiscrepancyReportRequest;
use App\Http\Requests\UpdateDiscrepancyReportRequest;
use App\Models\Product;
use App\Models\StockEntry;
use App\Models\StockExit;
use Illuminate\Support\Facades\DB;

class DiscrepancyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = DiscrepancyReport::with('user')->latest()->paginate(10);
        return view('inventory.discrepancy.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pasamos todos los productos activos para que el usuario pueda ingresar su conteo físico.
        $products = Product::where('status', 'active')->orderBy('name')->get();
        return view('inventory.discrepancy.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscrepancyReportRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            
            // 1. Crear el informe maestro
            $report = DiscrepancyReport::create([
                'user_id' => auth()->id(),
                'count_date' => $validated['count_date'],
                'general_remarks' => $validated['general_remarks'],
                'status' => 'open',
            ]);

            // 2. Recorrer los productos contados y guardar solo los que tienen discrepancias
            foreach ($validated['details'] as $detail) {
                $product = Product::find($detail['product_id']);
                $system_quantity = $product->stock;
                $physical_quantity = (int)$detail['physical_quantity'];
                $difference = $physical_quantity - $system_quantity;

                // Solo guardamos el detalle si hay una diferencia
                if ($difference != 0) {
                    $report->details()->create([
                        'product_id' => $product->id,
                        'system_quantity' => $system_quantity,
                        'physical_quantity' => $physical_quantity,
                        'difference' => $difference,
                        'justification' => $detail['justification'],
                    ]);
                }
            }

            // Opcional: si el informe no tiene detalles (ninguna discrepancia),
            // se puede borrar o dejar como constancia de que el conteo fue perfecto.
            // Lo dejaremos por motivos de auditoría.
        });

        return redirect()->route('discrepancies.index')->with('success', 'Informe de Discrepancia creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DiscrepancyReport $discrepancy)
    {
        $discrepancy->load(['user', 'details.product']);
        return view('inventory.discrepancy.show', compact('discrepancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DiscrepancyReport $discrepancy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscrepancyReportRequest $request, DiscrepancyReport $discrepancy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiscrepancyReport $discrepancy)
    {
        //
    }
    // --- ACCIÓN PERSONALIZADA PARA AJUSTAR STOCK ---

    /**
     * Procesa un informe y ajusta el stock para que coincida con el conteo físico.
     * Esta acción solo debe ser ejecutada por un Supervisor.
     */
    public function adjustStock(DiscrepancyReport $discrepancy)
    {
        // Solo se pueden procesar informes en estado 'open'
        if ($discrepancy->status !== 'open') {
            return redirect()->back()->with('error', 'Este informe ya ha sido procesado.');
        }

        DB::transaction(function () use ($discrepancy) {
            foreach ($discrepancy->details as $detail) {
                $product = $detail->product;
                $difference = $detail->difference;

                // Si la diferencia es positiva, es un sobrante -> registrar ENTRADA
                if ($difference > 0) {
                    StockEntry::create([
                        'product_id' => $product->id,
                        'user_id' => auth()->id(),
                        'quantity' => $difference,
                        'received_at' => now(),
                        // No asociamos a una orden de compra, es un ajuste
                    ]);
                }

                // Si la diferencia es negativa, es un faltante -> registrar SALIDA
                if ($difference < 0) {
                    StockExit::create([
                        'product_id' => $product->id,
                        'user_id' => auth()->id(),
                        'quantity' => abs($difference), // usamos el valor absoluto
                        'type' => 'Discrepancy Adjustment',
                        'reason' => 'Ajuste basado en informe de discrepancia #' . $discrepancy->id,
                        'exited_at' => now(),
                    ]);
                }
                
                // Sincronizar el stock del producto con el conteo físico real
                $product->update(['stock' => $detail->physical_quantity]);
            }
            
            // Cerrar el informe para que no se pueda procesar de nuevo
            $discrepancy->update(['status' => 'closed']);
        });

        return redirect()->route('discrepancies.show', $discrepancy)->with('success', 'El stock ha sido ajustado según el informe.');
    }
}
