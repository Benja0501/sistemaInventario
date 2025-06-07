<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\User;    
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = PurchaseOrder::with(['creator', 'supplier'])
            ->orderBy('order_date', 'desc')
            ->paginate(15);

        return view('inventory.purchase.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('business_name')->get();
        $users = User::orderBy('name')->get();
        return view('inventory.purchase.create', compact('suppliers', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        PurchaseOrder::create($request->validated());

        return redirect()->route('purchases.index')
            ->with('success', 'Orden de compra creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('creator', 'supplier', 'items');
        return view('inventory.purchase.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        $suppliers = Supplier::orderBy('business_name')->get();
        $users = User::orderBy('name')->get();
        return view('inventory.purchase.edit', compact('purchaseOrder', 'suppliers', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->update($request->validated());

        return redirect()->route('purchases.index')
            ->with('success', 'Orden de compra actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();

        return redirect()->route('purchases.index')
            ->with('success', 'Orden de compra eliminada correctamente.');
    }
}
