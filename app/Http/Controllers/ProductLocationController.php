<?php

namespace App\Http\Controllers;

use App\Models\ProductLocation;
use App\Models\Product;
use App\Models\Location;
use App\Http\Requests\StoreProductLocationRequest;
use App\Http\Requests\UpdateProductLocationRequest;

class ProductLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = ProductLocation::with(['product', 'location'])
            ->orderBy('product_id')
            ->paginate(15);

        return view('inventory.product_location.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        return view('inventory.product_location.create', compact('products', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductLocationRequest $request)
    {
        ProductLocation::create($request->validated());

        return redirect()->route('product_locations.index')
            ->with('success', 'Cantidad asignada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductLocation $productLocation)
    {
        return view('inventory.product_location.show', compact('product_location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductLocation $productLocation)
    {
        $products = Product::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        return view('inventory.product_location.edit', compact('product_location', 'products', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductLocationRequest $request, ProductLocation $productLocation)
    {
        $productLocation->update($request->validated());

        return redirect()->route('product_locations.index')
            ->with('success', 'Cantidad actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductLocation $productLocation)
    {
        $productLocation->delete();

        return redirect()->route('product_locations.index')
            ->with('success', 'Vínculo eliminado correctamente.');
    }
}
