<?php

namespace App\Notifications;

use App\Models\StockEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductExpiringSoon extends Notification
{
    use Queueable;

    protected StockEntry $entry;

    /**
     * Crea una nueva instancia de la notificación.
     * Aquí recibimos la "Entrada de Stock" que está por vencer desde nuestro comando programado.
     */
    public function __construct(StockEntry $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Define los canales por los que se enviará la notificación.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Definimos que esta alerta se enviará a la base de datos (para el inbox del sistema) y por correo electrónico.
        return ['database', 'mail'];
    }

    /**
     * Construye el correo electrónico que recibirá el supervisor.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->error() // Pinta el botón de rojo para indicar urgencia
                    ->subject('Alerta: Producto Próximo a Vencer')
                    ->greeting('¡Hola, ' . $notifiable->name . '!')
                    ->line("El lote '{$this->entry->batch}' del producto '{$this->entry->product->name}' está próximo a vencer.")
                    ->line("Fecha de vencimiento: " . $this->entry->expiration_date->format('d/m/Y'))
                    ->line("Cantidad en ese lote: {$this->entry->quantity} unidades.")
                    ->action('Ver Producto', route('products.show', $this->entry->product_id))
                    ->line('Por favor, considere tomar acciones como crear una oferta o darle prioridad de venta.');
    }

    /**
     * Define los datos que se guardarán en la base de datos y que se mostrarán en la lista de notificaciones.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'product_id' => $this->entry->product_id,
            'product_name' => $this->entry->product->name,
            'batch' => $this->entry->batch,
            'expiration_date' => $this->entry->expiration_date->format('d/m/Y'),
            'message' => "El lote {$this->entry->batch} de {$this->entry->product->name} vence el {$this->entry->expiration_date->format('d/m/Y')}.",
            'url' => route('products.show', $this->entry->product_id),
        ];
    }
}