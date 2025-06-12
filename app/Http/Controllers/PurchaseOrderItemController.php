<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrderItem;
use App\Http\Requests\StorePurchaseOrderItemRequest;
use App\Http\Requests\UpdatePurchaseOrderItemRequest;
use App\Models\PurchaseOrder;

class PurchaseOrderItemController extends Controller
{

    public function store(StorePurchaseOrderItemRequest $request)
    {
        PurchaseOrderItem::create($request->validated());

        return back()->with('success', 'Ítem agregado a la orden.');
    }

    public function update(UpdatePurchaseOrderItemRequest $request, PurchaseOrderItem $purchaseOrderItem)
    {
        $purchaseOrderItem->update($request->validated());

        return back()->with('success', 'Ítem actualizado correctamente.');
    }

    public function destroy(PurchaseOrderItem $purchaseOrderItem)
    {
        $purchaseOrderItem->delete();
        return back()->with('success', 'Ítem eliminado de la orden.');
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
}
