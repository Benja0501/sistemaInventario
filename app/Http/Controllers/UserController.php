<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $validatedData = $request->validated();
        
        User::create($validatedData);

        return redirect()->route('users.index')->with('success', 'Usuario creado con éxito.');
    }

    public function show(User $user)
    {
        return view('inventory.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('inventory.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validated();

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
