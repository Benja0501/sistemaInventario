<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Product;
use App\Http\Requests\StoreBatchRequest;
use App\Http\Requests\UpdateBatchRequest;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = Batch::with('product')
            ->orderBy('expiration_date')
            ->paginate(15);

        return view('inventory.batch.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('inventory.batch.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBatchRequest $request)
    {
        Batch::create($request->validated());

        return redirect()->route('batches.index')
            ->with('success', 'Lote creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        $batch->load('product');
        return view('inventory.batch.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        $products = Product::orderBy('name')->get();
        return view('inventory.batch.edit', compact('batch', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBatchRequest $request, Batch $batch)
    {
        $batch->update($request->validated());

        return redirect()->route('batches.index')
            ->with('success', 'Lote actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch)
    {
        $batch->delete();

        return redirect()->route('batches.index')
            ->with('success', 'Lote eliminado correctamente.');
    }
}
