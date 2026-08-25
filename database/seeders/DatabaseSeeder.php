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
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@blancfloreria.com',
            'password' => bcrypt('Blanc2026*'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'blanc',
            'email' => 'ventas@blancfloreria.com',
            'password' => bcrypt('Blanc2026*'),
            'role' => 'ventas',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'operacion',
            'email' => 'operacion@blancfloreria.com',
            'password' => bcrypt('Blanc2026*'),
            'role' => 'operacion',
        ]);
    }
}
