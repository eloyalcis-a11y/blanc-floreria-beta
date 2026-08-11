<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncNoriOrders extends Command
{
    protected $signature = 'nori:sync-orders';
    protected $description = 'Extrae los pedidos creados manualmente en la BD de Nori y los importa al Dashboard';

    public function handle()
    {
        $this->info('Iniciando sincronización con SQL Server (Nori)...');
        
        try {
            // Placeholder: Cuando el cliente proporcione los datos, aquí cambiaremos 'nori_orders_table' por el nombre real de su tabla.
            // $noriOrders = DB::connection('sqlsrv_nori')
            //     ->table('nori_orders_table')
            //     ->where('created_at', '>=', now()->subMinutes(60))
            //     ->get();

            $this->info('Conexión preparada. Esperando credenciales y nombres de tabla para habilitar el barrido.');
            Log::info('SyncNoriOrders ejecutado (En espera de credenciales).');

            /*
            // Ejemplo de Inserción:
            foreach ($noriOrders as $noriOrder) {
                Order::updateOrCreate(
                    ['nori_id' => $noriOrder->id], // Evitar duplicados
                    [
                        'order_number' => 'NORI-' . $noriOrder->id,
                        'client_name' => $noriOrder->customer_name,
                        'company' => $noriOrder->company,
                        'material' => 'Pedido Nori',
                        'quantity' => $noriOrder->qty,
                        'total_price' => $noriOrder->total,
                        'source' => 'Nori',
                        'status' => 'Confirmado',
                    ]
                );
            }
            */

        } catch (\Exception $e) {
            $this->error('Error de conexión a Nori: ' . $e->getMessage());
            Log::error('Error en SyncNoriOrders: ' . $e->getMessage());
        }
    }
}
