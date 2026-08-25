<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // El acceso es por 'username'; 'name' es solo el nombre visible.
        // updateOrCreate para que re-sembrar no truene por el unique.
        $cuentas = [
            ['username' => 'admin',     'name' => 'Administrador',  'role' => 'admin'],
            ['username' => 'blanc',     'name' => 'Blanc Floreria', 'role' => 'ventas'],
            ['username' => 'operacion', 'name' => 'Operacion',      'role' => 'operacion'],
        ];

        foreach ($cuentas as $cuenta) {
            \App\Models\User::updateOrCreate(
                ['username' => $cuenta['username']],
                [
                    'name' => $cuenta['name'],
                    'role' => $cuenta['role'],
                    'password' => bcrypt('Blanc2026*'),
                ]
            );
        }
    }

}
