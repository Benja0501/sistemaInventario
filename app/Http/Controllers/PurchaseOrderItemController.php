<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrderItem;
use App\Http\Requests\StorePurchaseOrderItemRequest;
use App\Http\Requests\UpdatePurchaseOrderItemRequest;

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
}
