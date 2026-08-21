<x-mail::message>
# Nuevo Pedido Registrado

Se ha registrado un nuevo pedido en el sistema de **Blanc Florería**.

<x-mail::panel>
**Acuse / Folio:** {{ $order->order_number }}
**Origen:** {{ ucfirst($order->source) }}
**Método de Pago:** {{ $order->payment_method ?: 'No especificado' }}
</x-mail::panel>

## Detalles del Pedido

- **Cliente:** {{ $order->client_name }}
- **Modelo/Código:** {{ $order->product_code ?: $order->material }}
- **Cantidad:** {{ $order->quantity }}
- **Fecha de Entrega:** {{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y') : 'Por definir' }}

@php
    $total = ($order->unit_price ?? 0) + ($order->extra_charge ?? 0) + ($order->shipping_cost ?? 0) - ($order->discount ?? 0);
@endphp
**Total Cobrado:** MX$ {{ number_format($total, 2) }}

<x-mail::button :url="config('app.url') . '/pedidos/' . $order->id">
Ver Pedido en el Sistema
</x-mail::button>

Gracias,<br>
Sistema Administrativo de {{ config('app.name') }}
</x-mail::message>
