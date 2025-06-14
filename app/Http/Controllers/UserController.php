<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PurchaseOrder;
use App\Models\StockEntry;
use App\Models\StockExit;
use App\Models\DiscrepancyReport;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('inventory.user.index', compact('users'));
    }

    public function create()
    {
        return view('inventory.user.create');
    }

    public function store(Request $request)
    {
        User::create($request->validated());
        return redirect()->route('users.index')->with('success', 'Usuario creado con éxito.');
    }

    public function show(User $user)
    {
        // Contamos las actividades clave asociadas a este usuario
        $stats = [
            'purchase_orders' => PurchaseOrder::where('user_id', $user->id)->count(),
            'stock_entries' => StockEntry::where('user_id', $user->id)->count(),
            'stock_exits' => StockExit::where('user_id', $user->id)->count(),
            'discrepancy_reports' => DiscrepancyReport::where('user_id', $user->id)->count(),
        ];

        return view('inventory.user.show', compact('user', 'stats'));
    }

    public function edit(User $user)
    {
        return view('inventory.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validated();

        // Si no se envió una nueva contraseña, la quitamos del array para no sobreescribirla
        if (empty($validatedData['password'])) {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        // Apuntamos a la nueva ruta 'users.index'
        return redirect()->route('users.index')->with('success', 'Usuario actualizado con éxito.');
    }

    public function destroy(User $user)
    {
        $user->update(['status' => 'inactive']);

        // Apuntamos a la nueva ruta 'users.index'
        return redirect()->route('users.index')->with('success', 'Usuario desactivado con éxito.');
    }
}
