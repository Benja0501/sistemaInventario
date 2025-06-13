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
        if (User::count() > 0) {
            // Si ya existe al menos un usuario, no muestra la página de registro pública.
            abort(404);
        }
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // No permitimos que nadie más se registre si ya existe el supervisor.
        if (User::count() > 0) {
            abort(403, 'Registro deshabilitado.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Asignar supervisor al primer usuario registrado.
        // Comprueba si ya existe algún usuario en la base de datos.
        $roleToAssign = User::count() === 0 ? 'supervisor' : 'warehouse';

        // Si ya hay usuarios, no permitimos el registro público.
        // Solo el supervisor podrá crear nuevos usuarios desde el panel.
        if (User::count() > 0) {
            // Podrías redirigir al login con un mensaje de error.
            return redirect()->route('login')->with('error', 'El registro público está deshabilitado.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            //'password' => Hash::make($request->password),
            'password' => $request->password,
            'role' => $roleToAssign,
            'status' => 'active',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
