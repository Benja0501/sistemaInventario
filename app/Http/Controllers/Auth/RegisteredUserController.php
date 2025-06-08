<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2) Obtén los IDs de los roles "Administrador" y "Usuario"
        $adminRoleId = Role::where('name', 'Administrador')->value('id');
        $userRoleId  = Role::where('name', 'Usuario')->value('id');

        // 3) Decide qué rol asignar:
        //    - Si no hay ningún usuario aún, primer registro → Administrador
        //    - En otro caso → Usuario (si existe), o Administrador si no existe rol "Usuario"
        $assignedRoleId = (User::count() === 0 && $adminRoleId)
                        ? $adminRoleId
                        : ($userRoleId ?: $adminRoleId);

        // 4) Crea el usuario con el rol asignado
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $assignedRoleId,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
