<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductLowStock extends Notification
{
    use Queueable;
    protected Product $product;

    /**
     * Create a new notification instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Alerta de Stock Bajo')
                    ->line("¡Atención! El producto '{$this->product->name}' ha alcanzado el nivel mínimo de stock.")
                    ->line("Stock actual: {$this->product->stock} unidades.")
                    ->action('Ver Producto', route('products.show', $this->product->id))
                    ->line('Por favor, considere generar una nueva orden de compra.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'current_stock' => $this->product->stock,
            'message' => "Stock bajo para el producto: {$this->product->name}. Stock actual: {$this->product->stock}.",
            'url' => route('products.show', $this->product->id),
        ];
    }
}
