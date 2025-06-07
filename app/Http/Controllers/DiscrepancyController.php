<?php

namespace App\Http\Controllers;

use App\Models\Discrepancy;
use App\Models\Product;
use App\Models\User;
use App\Http\Requests\StoreDiscrepancyRequest;
use App\Http\Requests\UpdateDiscrepancyRequest;

class DiscrepancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discrepancies = Discrepancy::with(['product', 'reporter'])
            ->orderBy('reported_at', 'desc')
            ->paginate(15);

        return view('inventory.discrepancy.index', compact('discrepancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('inventory.discrepancy.create', compact('products', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscrepancyRequest $request)
    {
        Discrepancy::create($request->validated());

        return redirect()->route('discrepancies.index')
            ->with('success', 'Discrepancia registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Discrepancy $discrepancy)
    {
        $discrepancy->load('product', 'reporter');
        return view('inventory.discrepancy.show', compact('discrepancy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discrepancy $discrepancy)
    {
        $products = Product::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('inventory.discrepancy.edit', compact('discrepancy', 'products', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscrepancyRequest $request, Discrepancy $discrepancy)
    {
        $discrepancy->update($request->validated());

        return redirect()->route('discrepancies.index')
            ->with('success', 'Discrepancia actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discrepancy $discrepancy)
    {
        $discrepancy->delete();

        return redirect()->route('discrepancies.index')
            ->with('success', 'Discrepancia eliminada correctamente.');

    }
}
