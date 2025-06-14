<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\StockEntry;
use App\Models\StockExit;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('inventory.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('inventory.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());
        return redirect()->route('products.index')->with('success', 'Producto creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Unimos las últimas 5 entradas y 5 salidas para este producto
        $entries = StockEntry::where('product_id', $product->id)->latest()->limit(5);
        $exits = StockExit::where('product_id', $product->id)->latest()->limit(5);

        $recentMovements = $entries->get()->map(function ($entry) {
            $entry->type = 'entry';
            return $entry;
        })->concat($exits->get()->map(function ($exit) {
            $exit->type = 'exit';
            $exit->created_at = $exit->exited_at;
            return $exit;
        }))->sortByDesc('created_at')->take(5);

        return view('inventory.product.show', compact('product', 'recentMovements'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->get();
        return view('inventory.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()->route('products.index')->with('success', 'Producto actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Verificamos si el producto tiene algún movimiento de stock asociado.
        if ($product->stockEntries()->exists() || $product->stockExits()->exists()) {
            // Si tiene historial, la mejor práctica es desactivarlo, no borrarlo.
            $product->update(['status' => 'inactive']);
            return redirect()->route('products.index')->with('success', 'El producto tiene historial, ha sido desactivado.');
        }

        // Si no tiene ningún historial (ej: se creó por error), se puede eliminar.
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado con éxito.');
    }
}
