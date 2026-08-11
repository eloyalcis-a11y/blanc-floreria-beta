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
        $admin = User::factory()->create([
            'name' => 'Admin Ventas',
            'email' => 'admin@verdemadera.com',
            'role' => 'admin',
        ]);

        $ops = User::factory()->create([
            'name' => 'Operaciones',
            'email' => 'ops@verdemadera.com',
            'role' => 'ops',
        ]);

        $client = User::factory()->create([
            'name' => 'Laura Mendoza',
            'email' => 'laura@grupohorizonte.com',
            'role' => 'client',
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
