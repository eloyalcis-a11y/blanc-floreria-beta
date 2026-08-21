<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class ShopifyWebhookController extends Controller
{
    public function handleOrderCreate(Request $request)
    {
        // El webhook viene en formato JSON
        $payload = $request->all();
        Log::info('Shopify Webhook Recibido: Order Create', ['order_id' => $payload['id'] ?? null]);

        // Evitar procesar si no trae ID
        if (empty($payload['id'])) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Filtrar pedidos no pagados (Solo aceptar 'paid')
        if (isset($payload['financial_status']) && $payload['financial_status'] !== 'paid') {
            Log::info('Shopify Webhook Ignorado: Pedido no pagado', [
                'order_id' => $payload['id'],
                'financial_status' => $payload['financial_status']
            ]);
            // Retornamos 200 para que Shopify no re-intente enviar el webhook de este pedido no pagado
            return response()->json(['message' => 'Ignored. Order is not paid.'], 200);
        }

        // 1. Extraer Cliente
        $clientName = 'Cliente Shopify';
        if (isset($payload['customer'])) {
            $clientName = trim(($payload['customer']['first_name'] ?? '') . ' ' . ($payload['customer']['last_name'] ?? ''));
        } elseif (isset($payload['billing_address']['name'])) {
            $clientName = $payload['billing_address']['name'];
        }

        // 2. Extraer Empresa
        $company = $payload['billing_address']['company'] ?? '';

        // 3. Extraer Material (Resumen de productos)
        $material = 'Varios';
        if (!empty($payload['line_items']) && isset($payload['line_items'][0]['title'])) {
            $material = $payload['line_items'][0]['title'];
            if (count($payload['line_items']) > 1) {
                $material .= ' (+' . (count($payload['line_items']) - 1) . ' items)';
            }
        }

        // 4. Extraer Cantidad Total
        $quantity = 0;
        if (!empty($payload['line_items'])) {
            foreach ($payload['line_items'] as $item) {
                $quantity += (int) ($item['quantity'] ?? 0);
            }
        }

        // 5. Precio
        $totalPrice = (float) ($payload['total_price'] ?? 0);

        // 6. Crear el pedido en nuestra base de datos local
        $order = Order::create([
            'order_number' => $payload['name'] ?? ('#' . ($payload['order_number'] ?? $payload['id'])), // Mantiene el folio exacto de Shopify (ej. #1024)
            'user_id' => 1, // Usuario administrador por defecto
            'client_name' => $clientName,
            'company' => $company,
            'material' => $material,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
            'delivery_date' => null, 
            'image_url' => null,
            'status' => 'Confirmado', // Entra directo como confirmado al estar pagado en Shopify
            'payment_method' => 'Shopify Payments',
            'is_in_route' => false,
            'source' => 'Shopify',
        ]);

        // 6.5. Enviar correo a la lista de distribución
        try {
            \Illuminate\Support\Facades\Mail::to([
                'jaky.vazquez@alciscorp.com',
                'andrea.orquidea@alciscorp.com',
                'atencionaclientes@blancfloreria.com.mx',
                'asistente2@alciscorp.com'
            ])->send(new \App\Mail\OrderCreatedMail($order));
        } catch (\Exception $e) {
            Log::error('Error enviando correo de nuevo pedido Shopify: ' . $e->getMessage());
        }

        // 7. Enviar a Nori (Placeholder para cuando tengamos la BD conectada)
        try {
            /*
            DB::connection('sqlsrv_nori')->table('nori_orders_table')->insert([
                'order_id' => $order->order_number,
                'customer_name' => $clientName,
                'total' => $totalPrice,
                // ... otras columnas según el diccionario de datos de Nori
            ]);
            */
            Log::info('Shopify order enviada a Nori exitosamente (Simulado).');
        } catch (\Exception $e) {
            Log::error('Error al mandar pedido a Nori: ' . $e->getMessage());
        }

        return response()->json(['message' => 'Webhook procesado correctamente'], 200);
    }
}
