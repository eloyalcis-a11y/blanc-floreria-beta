<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->where('status', 'Cerrado (Pagado)');

        // 1. Filtrado de Fechas
        $dateRange = $request->get('date_range', 'mes'); // por defecto este mes
        if ($dateRange === 'hoy') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($dateRange === 'semana') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($dateRange === 'mes') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } elseif ($dateRange === 'custom' && $request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // 2. Filtros Adicionales (Origen, Estado)
        if ($request->filled('source') && $request->source !== 'Todos') {
            $query->where('source', $request->source);
        }
        if ($request->filled('payment_method') && $request->payment_method !== 'Todos') {
            $query->where('payment_method', $request->payment_method);
        }

        // 3. Cálculos de Métricas
        // Clonamos el query para no afectar a la paginación de la tabla de preview
        $metricsQuery = clone $query;
        $ordersForMetrics = $metricsQuery->get();

        $totalIngresos = 0;
        $totalEnvios = 0;
        $paymentMethodTotals = [];
        
        foreach ($ordersForMetrics as $order) {
            // Formula del total del pedido: unit_price * (1 - discount%) + extra_charge + shipping_cost
            $totalOrder = (($order->unit_price ?? 0) * (1 - ($order->discount ?? 0) / 100)) + ($order->extra_charge ?? 0) + ($order->shipping_cost ?? 0);
            $totalIngresos += $totalOrder;
            $totalEnvios += ($order->shipping_cost ?? 0);
            
            // Agrupar totales por método de pago
            $method = $order->payment_method ?: 'No Especificado';
            if (!isset($paymentMethodTotals[$method])) {
                $paymentMethodTotals[$method] = 0;
            }
            $paymentMethodTotals[$method] += $totalOrder;
        }

        $cantidadPedidos = $ordersForMetrics->count();
        $ticketPromedio = $cantidadPedidos > 0 ? ($totalIngresos / $cantidadPedidos) : 0;

        // Top Venta / Modelo
        $topModelo = clone $query;
        $topVendido = $topModelo->selectRaw('product_code, count(*) as total')
            ->whereNotNull('product_code')
            ->groupBy('product_code')
            ->orderByDesc('total')
            ->first();

        // 4. Listado para la tabla de previsualización
        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('reports', compact(
            'orders',
            'totalIngresos',
            'ticketPromedio',
            'totalEnvios',
            'cantidadPedidos',
            'dateRange',
            'topVendido',
            'paymentMethodTotals'
        ));
    }

    public function export(Request $request)
    {
        $query = Order::query()->where('status', 'Cerrado (Pagado)');

        // Aplicar los mismos filtros que en el index
        $dateRange = $request->get('date_range', 'mes');
        if ($dateRange === 'hoy') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($dateRange === 'semana') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($dateRange === 'mes') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        } elseif ($dateRange === 'custom' && $request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        }

        // Aplicar filtros similares a los del dashboard si se reciben
        if ($request->filled('payment_method') && $request->payment_method !== 'Todos') {
            $query->where('payment_method', $request->payment_method);
        }
        if ($request->filled('source') && $request->source !== 'Todos') {
            $query->where('source', $request->source);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=reporte_pedidos_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Usamos una función de callback para procesar el CSV sin gastar memoria
        $callback = function() use($orders) {
            $file = fopen('php://output', 'w');
            
            // Agregar UTF-8 BOM para que Excel lo lea bien (acentos, ñ, etc.)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Encabezados exactos del Excel OCASIONES 2026 REPORTE
            fputcsv($file, [
                '#NOTA',
                'MODELO',
                'NOMBRE COMPLETO DEL SOLICITANTE2',
                'FECHA DE ENTREGA',
                'CANTIDAD',
                '# Transito',
                'Costo SAP',
                'P.U..3',
                'SUBTOTAL',
                'DESCUENTO (%)',
                'GASTO ENVÍO',
                'ADICIONAL',
                'MÉTODO DE PAGO',
                'TOTAL',
                '#TICKET',
                'FECHA DE CORTE'
            ]);

            foreach ($orders as $order) {
                // Modelo puede ser product_code o material si no hay código
                $modelo = $order->product_code ?: $order->material;
                $qty = intval($order->quantity ?? 1);
                
                // Parche para pedidos antiguos de Shopify que contaron "Cliente Blanc" como cantidad
                if ($order->source === 'Shopify' && $qty > 1 && str_contains(strtolower($modelo), 'cliente blanc')) {
                    $qty -= 1;
                }

                $subtotal = floatval($order->unit_price ?? 0);
                $pu = $qty > 0 ? $subtotal / $qty : $subtotal;
                $extra = floatval($order->extra_charge ?? 0) + floatval($order->shipping_cost ?? 0) - (floatval($order->unit_price ?? 0) * floatval($order->discount ?? 0) / 100);
                $total = $subtotal + $extra;
                $deliveryDate = $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d') : '';

                fputcsv($file, [
                    $order->order_number,
                    $modelo,
                    $order->client_name,
                    $deliveryDate,
                    $qty,
                    '', // # Transito (vacío manual)
                    '', // Costo SAP (vacío manual)
                    $pu,
                    $subtotal,
                    $order->discount ?? 0,
                    $order->shipping_cost ?? 0,
                    $order->extra_charge ?? 0,
                    $order->payment_method,
                    $total,
                    $order->ticket_number ?? 'N/A',
                    $order->created_at->format('Y-m-d')
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
