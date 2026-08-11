<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;

class SimulateShopifyOrder extends Command
{
    protected $signature = 'shopify:simulate';
    protected $description = 'Simula la llegada de un pedido desde Shopify a Verde Madera';

    public function handle()
    {
        $this->info('Simulando llegada de Webhook de Shopify...');

        $order = Order::create([
            'order_number' => 'SHOP-' . rand(1000, 9999),
            'user_id' => 1, // Usuario administrador por defecto
            'client_name' => 'Ana Garcia (Shopify)',
            'company' => 'Corporativo ABC',
            'material' => 'Arreglo Floral Premium (+1 items)',
            'quantity' => 3,
            'total_price' => 1499.00,
            'delivery_date' => null,
            'image_url' => null,
            'status' => 'Confirmado',
            'is_in_route' => false,
            'source' => 'Shopify',
        ]);

        $this->info("¡Éxito! Pedido {$order->order_number} de Shopify insertado en la base de datos.");
        $this->info("Refresca tu dashboard para verlo.");
    }
}
