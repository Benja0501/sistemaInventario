<?php

namespace App\Http\Controllers;

use App\Models\StockEntry;
use App\Models\Product;
use App\Http\Requests\StoreStockEntryRequest;
use App\Http\Requests\UpdateStockEntryRequest;
use Illuminate\Support\Facades\DB;

class StockEntryController extends Controller
{
    public function index()
    {
        $stockEntries = StockEntry::with(['product', 'user', 'purchaseOrder'])
            ->latest('received_at')
            ->paginate(15);

        return view('inventory.entry.index', compact('stockEntries'));
    }
    public function create()
    {
        $products = Product::where('status', 'active')->get();
        return view('inventory.entry.create', compact('products'));
    }
    public function store(StoreStockEntryRequest $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
            'batch' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
            // Podríamos añadir un campo 'motivo' si quisiéramos
        ]);

        DB::transaction(function () use ($request) {
            // 1. Crear el registro de la entrada de stock
            StockEntry::create([
                'product_id' => $request->product_id,
                'user_id' => auth()->id(),
                'quantity' => $request->quantity,
                'reason' => $request->reason,
                'batch' => $request->batch,
                'expiration_date' => $request->expiration_date,
                'received_at' => now(),
                // purchase_order_id se deja en null porque no viene de una compra
            ]);

            // 2. Incrementar el stock del producto
            Product::find($request->product_id)->increment('stock', $request->quantity);
        });

        return redirect()->route('entries.index')->with('success', 'Entrada manual registrada con éxito.');
    }
    // public function show(StockEntry $stockEntry)
    // {
    //     $stockEntry->load(['product', 'user', 'purchaseOrder']);
    //     return view('inventory.entry.show', compact('stockEntry'));
    // }
    public function edit(StockEntry $stockEntry)
    {
        //
    }
    public function update(UpdateStockEntryRequest $request, StockEntry $stockEntry)
    {
        //
    }
    public function destroy(StockEntry $stockEntry)
    {
        //
    }
}
