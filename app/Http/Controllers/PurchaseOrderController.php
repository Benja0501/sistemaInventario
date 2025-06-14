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
        DB::transaction(function () use ($request) {
            $validated = $request->validated();
            $total = 0;

            foreach ($validated['details'] as $detail) {
                $total += $detail['quantity'] * $detail['unit_price'];
            }

            // --- LÍNEAS AÑADIDAS ---
            // 1. Generamos un número de orden único.
            // Ejemplo: PO-1718409600 (PO + fecha y hora actual en segundos)
            $orderNumber = 'PO-' . time();

            // 2. Crear la orden de compra, incluyendo el nuevo número de orden
            $purchaseOrder = PurchaseOrder::create([
                'order_number' => $orderNumber, // <-- Se añade el nuevo campo
                'supplier_id' => $validated['supplier_id'],
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'pending',
                'remarks' => $validated['remarks'],
            ]);

            // Crear los detalles de la orden (esto no cambia)
            foreach ($validated['details'] as $detail) {
                $purchaseOrder->details()->create($detail);
            }
        });

        return redirect()->route('purchases.index')->with('success', 'Orden de Compra creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchase)
    {
        $purchase->load(['supplier', 'user', 'approver', 'details.product']);
        return view('inventory.purchase.show', compact('purchase'));
    }

    // public function edit(PurchaseOrder $purchase)
    // {
    //     if ($purchase->status !== 'pending') {
    //         return redirect()->route('purchases.show', $purchase)->with('error', 'Solo se pueden editar órdenes en estado "Pendiente".');
    //     }

    //     $suppliers = Supplier::where('status', 'active')->get();
    //     $products = Product::where('status', 'active')->get();
    //     return view('inventory.purchase.edit', compact('purchase', 'suppliers', 'products'));
    // }

    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchase)
    {
        if ($purchase->status !== 'pending') {
            return redirect()->route('purchases.show', $purchase)->with('error', 'Solo se pueden editar órdenes en estado "Pendiente".');
        }

        DB::transaction(function () use ($request, $purchase) {
            $validated = $request->validated();
            $total = 0;

            // Calcular el nuevo total
            foreach ($validated['details'] as $detail) {
                $total += $detail['quantity'] * $detail['unit_price'];
            }

            // Actualizar la orden de compra (maestro)
            $purchase->update([
                'supplier_id' => $validated['supplier_id'],
                'total' => $total,
                'remarks' => $validated['remarks'],
            ]);

            // Eliminar los detalles antiguos y crear los nuevos
            $purchase->details()->delete();
            foreach ($validated['details'] as $detail) {
                $purchase->details()->create($detail);
            }
        });

        return redirect()->route('purchases.index')->with('success', 'Orden de Compra actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchase)
    {
        // Solo se pueden cancelar órdenes pendientes o aprobadas (que aún no se han recibido).
        if (!in_array($purchase->status, ['pending', 'approved'])) {
            return redirect()->back()->with('error', 'No se puede cancelar una orden que ya ha sido procesada.');
        }

        $purchase->update(['status' => 'canceled']);

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
    public function approve(PurchaseOrder $purchase)
    {
        if ($purchase->status !== 'pending') {
            return redirect()->back()->with('error', 'Esta orden no puede ser aprobada.');
        }

        $purchase->update([
            'status' => 'approved',
            'approved_by_id' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Notificar al usuario que creó la orden (si no es el mismo supervisor)
        // Notification::send($purchaseOrder->user, new PurchaseOrderApproved($purchaseOrder));

        return redirect()->route('purchases.show', $purchase)->with('success', 'Orden de Compra Aprobada.');
    }

    /**
     * Registra la recepción de productos de una orden. Caso de Uso de tu informe. 
     */
    public function registerReception(Request $request, PurchaseOrder $purchase)
    {
        if ($purchase->status !== 'approved') {
            return redirect()->back()->with('error', 'Solo se pueden recibir productos de órdenes aprobadas.');
        }

        DB::transaction(function () use ($request, $purchase) {
            $totalPedido = $purchase->details->sum('quantity');
            $totalRecibido = 0;

            foreach ($request->details as $itemRecibido) {
                $cantidad = (int) $itemRecibido['quantity'];
                if ($cantidad > 0) {
                    // Actualizar el stock del producto
                    Product::find($itemRecibido['product_id'])->increment('stock', $cantidad);

                    // Registrar el movimiento en la tabla de entradas
                    StockEntry::create([
                        'product_id' => $itemRecibido['product_id'],
                        'purchase_order_id' => $purchase->id,
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
            $purchase->update(['status' => $status]);
        });

        return redirect()->route('purchases.show', $purchase)->with('success', 'Recepción de productos registrada con éxito.');
    }
}
