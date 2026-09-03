<x-mail::message>
# ¡Hola {{ $order->client_name }}!

Te informamos que tu pedido **{{ $order->order_number }}** ha sido entregado exitosamente.

Agradecemos tu preferencia y esperamos que el arreglo haya sido de tu agrado.

Puedes ver los detalles y la foto de entrega en el siguiente enlace:

<x-mail::button :url="route('tracking.show', $order->order_number)">
Ver Mi Pedido
</x-mail::button>

Gracias,<br>
El equipo de {{ config('app.name') }}
</x-mail::message>
