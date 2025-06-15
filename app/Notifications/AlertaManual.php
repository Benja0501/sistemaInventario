<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlertaManual extends Notification
{
    use Queueable;

    protected string $subject;
    protected string $message;
    protected string $priority;

    /**
     * Crea una nueva instancia de la notificación.
     */
    public function __construct(string $subject, string $message, string $priority = 'info')
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->priority = $priority;
    }

    /**
     * Define los canales por los que se enviará la notificación.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // La enviaremos a la base de datos (para el inbox) y por email.
        return ['database', 'mail'];
    }

    /**
     * Define la representación para el correo electrónico.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting('Hola, ' . $notifiable->name . '!')
            ->line($this->message)
            ->line('Este es un mensaje enviado desde el sistema de inventario.')
            ->action('Ir al Dashboard', route('dashboard'));
    }

    /**
     * Define la representación para la base de datos (lo que se muestra en el inbox).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'subject' => $this->subject,
            'message' => $this->message,
            'priority' => $this->priority,
            'url' => route('notifications.index'), // Enlace genérico al centro de notificaciones
        ];
    }
}