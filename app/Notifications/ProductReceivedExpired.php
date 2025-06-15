<?php

namespace App\Notifications;

use App\Models\StockEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductReceivedExpired extends Notification
{
    use Queueable;

    protected StockEntry $entry;

    /**
     * Crea una nueva instancia de la notificación.
     */
    public function __construct(StockEntry $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Define los canales de envío.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Construye el correo electrónico de alerta.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->error() // Botón rojo de urgencia
                    ->subject('¡Alerta de Calidad! Producto Vencido Registrado')
                    ->greeting('¡Atención, ' . $notifiable->name . '!')
                    ->line("Se ha registrado un producto que ya se encuentra VENCIDO.")
                    ->line("Producto: {$this->entry->product->name}")
                    ->line("Lote: {$this->entry->batch}")
                    ->line("Fecha de vencimiento: " . $this->entry->expiration_date->format('d/m/Y'))
                    ->action('Ver Entrada de Stock', route('stock-entries.show', $this->entry->id))
                    ->line('Por favor, tome las acciones correctivas necesarias.');
    }

    /**
     * Define los datos que se guardan en la base de datos (para el inbox).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_name' => $this->entry->product->name,
            'batch' => $this->entry->batch,
            'expiration_date' => $this->entry->expiration_date->format('d/m/Y'),
            'message' => "¡Alerta! Se registró el producto VENCIDO '{$this->entry->product->name}' (Lote: {$this->entry->batch}).",
            'url' => route('stock-entries.show', $this->entry->id),
        ];
    }
}