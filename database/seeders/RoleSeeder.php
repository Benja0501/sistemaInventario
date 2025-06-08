<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrador', 'permissions' => null],
            ['name' => 'Usuario',       'permissions' => null],
        ];

        foreach ($roles as $data) {
            Role::firstOrCreate(
                ['name' => $data['name']],
                ['permissions' => $data['permissions']]
            );
        }
    }
}
