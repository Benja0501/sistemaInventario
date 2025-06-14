<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\StockEntry;
use App\Models\Product;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PurchaseOrderApproved;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with(['supplier', 'user'])->latest()->paginate(10);
        return view('inventory.purchase.index', compact('purchaseOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Necesitamos proveedores y productos activos para los selectores del formulario
        $suppliers = Supplier::where('status', 'active')->get();
        $products = Product::where('status', 'active')->get();
        return view('inventory.purchase.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        // Usamos una transacción para asegurar que si algo falla, nada se guarde.
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $total = 0;

            // Calcular el total
            foreach ($validated['details'] as $detail) {
                $total += $detail['quantity'] * $detail['unit_price'];
            }

            // Crear la orden de compra (maestro)
            $purchaseOrder = PurchaseOrder::create([
                'supplier_id' => $validated['supplier_id'],
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'pending',
                'remarks' => $validated['remarks'],
            ]);

            // Crear los detalles de la orden
            foreach ($validated['details'] as $detail) {
                $purchaseOrder->details()->create([
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'unit_price' => $detail['unit_price'],
                ]);
            }
        });

        return redirect()->route('purchases.index')->with('success', 'Orden de Compra creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        // Cargar todas las relaciones para mostrar una vista completa
        $purchaseOrder->load(['supplier', 'user', 'approver', 'details.product']);
        return view('inventory.purchase.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(PurchaseOrder $purchaseOrder)
    // {
    //     if ($purchaseOrder->status !== 'pending') {
    //         return redirect()->route('purchases.show', $purchaseOrder)->with('error', 'Solo se pueden editar órdenes en estado "Pendiente".');
    //     }

    //     $suppliers = Supplier::where('status', 'active')->get();
    //     $products = Product::where('status', 'active')->get();
    //     return view('inventory.purchase.edit', compact('purchaseOrder', 'suppliers', 'products'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->route('purchases.show', $purchaseOrder)->with('error', 'Solo se pueden editar órdenes en estado "Pendiente".');
        }

        DB::transaction(function () use ($request, $purchaseOrder) {
            $validated = $request->validated();
            $total = 0;

            // Calcular el nuevo total
            foreach ($validated['details'] as $detail) {
                $total += $detail['quantity'] * $detail['unit_price'];
            }
            
            // Actualizar la orden de compra (maestro)
            $purchaseOrder->update([
                'supplier_id' => $validated['supplier_id'],
                'total' => $total,
                'remarks' => $validated['remarks'],
            ]);

            // Eliminar los detalles antiguos y crear los nuevos
            $purchaseOrder->details()->delete();
            foreach ($validated['details'] as $detail) {
                $purchaseOrder->details()->create($detail);
            }
        });

        return redirect()->route('purchases.index')->with('success', 'Orden de Compra actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        // Solo se pueden cancelar órdenes pendientes o aprobadas (que aún no se han recibido).
        if (!in_array($purchaseOrder->status, ['pending', 'approved'])) {
            return redirect()->back()->with('error', 'No se puede cancelar una orden que ya ha sido procesada.');
        }

        $purchaseOrder->update(['status' => 'canceled']);

        return redirect()->route('purchases.index')->with('success', 'Orden de Compra cancelada.');
    }

    public function ajaxItems(PurchaseOrder $purchase)
    {
        // cargar relación items→product
        $items = $purchase->items()->with('product')->get()->map(function ($it) {
            return [
                'id' => $it->id,
                'product' => $it->product->name,
                'ordered' => $it->quantity,
                'unit_price' => $it->unit_price,
            ];
        });
        return response()->json($items);
    }

    // --- MÉTODOS DE ACCIONES PERSONALIZADAS ---

    /**
     * Aprueba una orden de compra. Caso de Uso de tu informe. 
     */
    public function approve(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'pending') {
            return redirect()->back()->with('error', 'Esta orden no puede ser aprobada.');
        }

        $purchaseOrder->update([
            'status' => 'approved',
            'approved_by_id' => auth()->id(),
            'approved_at' => now(),
        ]);
        
        // Notificar al usuario que creó la orden (si no es el mismo supervisor)
        // Notification::send($purchaseOrder->user, new PurchaseOrderApproved($purchaseOrder));

        return redirect()->route('purchases.show', $purchaseOrder)->with('success', 'Orden de Compra Aprobada.');
    }

    /**
     * Registra la recepción de productos de una orden. Caso de Uso de tu informe. 
     */
    public function registerReception(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'approved') {
            return redirect()->back()->with('error', 'Solo se pueden recibir productos de órdenes aprobadas.');
        }

        DB::transaction(function () use ($request, $purchaseOrder) {
            $totalPedido = $purchaseOrder->details->sum('quantity');
            $totalRecibido = 0;

            foreach ($request->details as $itemRecibido) {
                $cantidad = (int)$itemRecibido['quantity'];
                if ($cantidad > 0) {
                    // Actualizar el stock del producto
                    Product::find($itemRecibido['product_id'])->increment('stock', $cantidad);

                    // Registrar el movimiento en la tabla de entradas
                    StockEntry::create([
                        'product_id' => $itemRecibido['product_id'],
                        'purchase_order_id' => $purchaseOrder->id,
                        'user_id' => auth()->id(),
                        'quantity' => $cantidad,
                        'batch' => $itemRecibido['batch'],
                        'expiration_date' => $itemRecibido['expiration_date'],
                        'received_at' => now(),
                    ]);
                    $totalRecibido += $cantidad;
                }
            }

            // Actualizar el estado de la orden de compra
            $status = ($totalRecibido >= $totalPedido) ? 'completed' : 'partial_received';
            $purchaseOrder->update(['status' => $status]);
        });

        return redirect()->route('purchases.show', $purchaseOrder)->with('success', 'Recepción de productos registrada con éxito.');
    }
}
