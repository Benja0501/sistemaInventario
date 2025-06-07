<?php

namespace App\Http\Controllers;

use App\Models\ReceptionItem;
use App\Http\Requests\StoreReceptionItemRequest;
use App\Http\Requests\UpdateReceptionItemRequest;

class ReceptionItemController extends Controller
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
    public function store(StoreReceptionItemRequest $request)
    {
        ReceptionItem::create($request->validated());

        return back()->with('success', 'Ítem agregado a la recepción.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReceptionItem $receptionItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReceptionItem $receptionItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReceptionItemRequest $request, ReceptionItem $receptionItem)
    {
        $receptionItem->update($request->validated());

        return back()->with('success', 'Ítem actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReceptionItem $receptionItem)
    {
        $receptionItem->delete();

        return back()->with('success', 'Ítem eliminado de la recepción.');
    }
}
