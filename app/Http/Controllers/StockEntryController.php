<?php

namespace App\Http\Controllers;

use App\Models\StockEntry;
use App\Http\Requests\StoreStockEntryRequest;
use App\Http\Requests\UpdateStockEntryRequest;

class StockEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockEntryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StockEntry $stockEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockEntry $stockEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockEntryRequest $request, StockEntry $stockEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockEntry $stockEntry)
    {
        //
    }
}
