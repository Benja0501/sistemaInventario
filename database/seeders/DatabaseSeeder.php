<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Puebla la base de datos de la aplicación.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Supervisor',
            'email' => 'admin@femaza.com', // Usa un correo real para ti
            'password' => 'password', // ¡Recuerda cambiar esto por una contraseña segura!
            'role' => 'supervisor', // Asignamos el rol directamente
            'status' => 'active',
        ]);
    }
}