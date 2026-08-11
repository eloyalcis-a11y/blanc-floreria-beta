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
            'name' => 'Admin Blanc Florería',
            'email' => 'admin@blancfloreria.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Ventas',
            'email' => 'ventas@blancfloreria.com',
            'password' => bcrypt('password'),
            'role' => 'ventas',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Operación',
            'email' => 'operacion@blancfloreria.com',
            'password' => bcrypt('password'),
            'role' => 'operacion',
        ]);

        $client = \App\Models\User::factory()->create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@blancfloreria.com',
            'password' => bcrypt('password'),
            'role' => 'cliente',
        ]);

        // Create some sample orders based on the mockup
        \App\Models\Order::create([
            'user_id' => $client->id,
            'order_number' => 'PD-1284',
            'client_name' => 'Laura Mendoza',
            'company' => 'Grupo Horizonte',
            'material' => 'Arreglo Orquídeas Blancas',
            'quantity' => 2,
            'total_price' => 12500,
            'status' => 'Confirmado',
            'delivery_date' => now()->addDays(5),
            'is_in_route' => false,
        ]);

        \App\Models\Order::create([
            'user_id' => $client->id, // just reusing for simplicity
            'order_number' => 'PD-1283',
            'client_name' => 'Carlos Ruiz',
            'company' => 'Innovatech S.A.',
            'material' => 'Arreglo Floral Premium 100 Rosas',
            'quantity' => 1,
            'total_price' => 28800,
            'status' => 'En producción',
            'delivery_date' => now()->addDays(2),
            'is_in_route' => false,
        ]);

        \App\Models\Order::create([
            'user_id' => $client->id,
            'order_number' => 'PD-1282',
            'client_name' => 'Ana Torres',
            'company' => 'Arreglo Tulipanes y Lilies',
            'material' => 'Arreglo Tulipanes y Lilies',
            'quantity' => 3,
            'total_price' => 7200,
            'status' => 'Entregado',
            'delivery_date' => now()->subDays(1),
            'is_in_route' => false,
        ]);

        \App\Models\Order::create([
            'user_id' => $client->id,
            'order_number' => 'PD-1281',
            'client_name' => 'Fernanda López',
            'company' => 'Centro de Mesa Floral',
            'material' => 'Centro de Mesa Floral',
            'quantity' => 5,
            'total_price' => 6250,
            'status' => 'Cotizado',
            'delivery_date' => now()->addDays(10),
            'is_in_route' => false,
        ]);
    }
}
