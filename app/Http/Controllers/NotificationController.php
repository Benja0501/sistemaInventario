<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\AlertaManual; // La creamos anteriormente
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    /**
     * Muestra el "inbox" de notificaciones del usuario logueado.
     */
    public function index()
    {
        // Obtenemos todas las notificaciones del usuario actual, paginadas
        $notifications = auth()->user()->notifications()->paginate(15);

        // Marcamos las notificaciones no leídas como leídas al visitar la página
        auth()->user()->unreadNotifications->markAsRead();

        return view('inventory.notification.index', compact('notifications'));
    }

    /**
     * Muestra el formulario para crear una alerta manual.
     */
    public function createManual()
    {
        // Obtenemos todos los usuarios para el selector de destinatario individual (opcional)
        $users = User::where('status', 'active')->orderBy('name')->get();
        return view('inventory.notification.create', compact('users'));
    }

    /**
     * Envía una alerta manual a los usuarios seleccionados.
     */
    public function storeManual(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|in:all,role,user',
            'role' => 'required_if:recipient_type,role|in:supervisor,purchasing,warehouse',
            'user_id' => 'required_if:recipient_type,user|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $recipients = null;

        // Determinar los destinatarios
        switch ($request->recipient_type) {
            case 'all':
                $recipients = User::where('status', 'active')->get();
                break;
            case 'role':
                $recipients = User::where('role', $request->role)->where('status', 'active')->get();
                break;
            case 'user':
                $recipients = User::find($request->user_id);
                break;
        }

        if ($recipients) {
            // Usamos la clase de notificación que ya habíamos diseñado
            Notification::send($recipients, new AlertaManual(
                $request->subject,
                $request->message,
                'info' // Se puede añadir un campo de prioridad si se desea
            ));
        }

        return redirect()->route('notifications.index')->with('success', 'Alerta enviada correctamente.');
    }
}