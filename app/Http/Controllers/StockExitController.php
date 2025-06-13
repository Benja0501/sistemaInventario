<?php

namespace App\Http\Controllers;

use App\Models\StockExit;
use App\Models\Product;
use App\Http\Requests\StoreStockExitRequest;
use App\Http\Requests\UpdateStockExitRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\ProductLowStock;

class StockExitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockExits = StockExit::with(['product', 'user'])
            ->latest('exited_at')
            ->paginate(15);

        return view('inventory.exit.index', compact('stockExits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('status', 'active')->get();
        return view('inventory.exit.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockExitRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            // 1. Crear el registro de la salida de stock
            StockExit::create([
                'product_id' => $validated['product_id'],
                'user_id' => auth()->id(),
                'quantity' => $validated['quantity'],
                'type' => $validated['type'],
                'reason' => $validated['reason'],
                'exited_at' => now(),
            ]);

            // 2. Decrementar el stock del producto
            $product = Product::find($validated['product_id']);
            $product->decrement('stock', $validated['quantity']);

            // 3. Opcional pero recomendado: Verificar si el stock cayó por debajo del mínimo
            if ($product->stock <= $product->minimum_stock) {
                $supervisors = User::where('role', 'supervisor')->get();
                Notification::send($supervisors, new ProductLowStock($product));
            }
        });

        return redirect()->route('exits.index')->with('success', 'Salida de stock registrada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockExit $stockExit)
    {
        $stockExit->load(['product', 'user']);
        return view('inventory.exit.show', compact('stockExit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockExit $stockExit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockExitRequest $request, StockExit $stockExit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockExit $stockExit)
    {
        //
    }
}
