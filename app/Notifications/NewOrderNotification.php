<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class NewOrderNotification extends Notification
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('¡Nuevo Pedido Recibido! - ' . $this->order->order_number)
                    ->greeting('¡Hola equipo!')
                    ->line('Se ha registrado un nuevo pedido en la plataforma.')
                    ->line('Cliente: ' . $this->order->client_name)
                    ->line('Total: $' . number_format((float)$this->order->total_price, 2))
                    ->action('Ver Detalles del Pedido', route('orders.show', $this->order->id))
                    ->line('Por favor, atiende este pedido lo más pronto posible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'client_name' => $this->order->client_name,
            'message' => 'Nuevo pedido recibido de ' . $this->order->client_name,
        ];
    }
}
