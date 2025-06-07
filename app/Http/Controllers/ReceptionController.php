<?php

namespace App\Http\Controllers;

use App\Models\Reception;
use App\Models\PurchaseOrder;
use App\Models\User;
use App\Http\Requests\StoreReceptionRequest;
use App\Http\Requests\UpdateReceptionRequest;

class ReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receptions = Reception::with(['purchaseOrder', 'receiver'])
            ->orderBy('received_at', 'desc')
            ->paginate(15);

        return view('inventory.reception.index', compact('receptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = PurchaseOrder::orderBy('order_date', 'desc')->get();
        $users = User::orderBy('name')->get();
        return view('inventory.reception.create', compact('orders', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReceptionRequest $request)
    {
        Reception::create($request->validated());

        return redirect()->route('receptions.index')
            ->with('success', 'Recepción creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reception $reception)
    {
        $reception->load('purchaseOrder', 'receiver', 'items');
        return view('inventory.reception.show', compact('reception'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reception $reception)
    {
        $orders = PurchaseOrder::orderBy('order_date', 'desc')->get();
        $users = User::orderBy('name')->get();
        return view('inventory.reception.edit', compact('reception', 'orders', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReceptionRequest $request, Reception $reception)
    {
        $reception->update($request->validated());

        return redirect()->route('receptions.index')
            ->with('success', 'Recepción actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reception $reception)
    {
        $reception->delete();

        return redirect()->route('receptions.index')
            ->with('success', 'Recepción eliminada correctamente.');
    }
}
