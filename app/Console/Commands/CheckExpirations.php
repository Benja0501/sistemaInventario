<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StockEntry;
use App\Models\User;
use App\Notifications\ProductExpiringSoon; // Crearemos esta notificación
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class CheckExpirations extends Command
{
    protected $signature = 'inventory:check-expirations';
    protected $description = 'Revisa los lotes de productos próximos a vencer y envía notificaciones.';

    public function handle()
    {
        $this->info('Buscando productos próximos a vencer...');

        // Buscamos entradas de stock cuya fecha de vencimiento esté en los próximos 30 días
        $expiringEntries = StockEntry::where('expiration_date', '<=', Carbon::now()->addDays(30))
                                     ->where('expiration_date', '>', Carbon::now())
                                     ->whereHas('product', function ($query) {
                                         $query->where('stock', '>', 0); // Solo si aún hay stock de ese producto
                                     })
                                     ->get();

        if ($expiringEntries->isEmpty()) {
            $this->info('No se encontraron productos próximos a vencer.');
            return;
        }

        // Obtenemos a los supervisores a quienes notificar
        $supervisors = User::where('role', 'supervisor')->get();

        foreach ($expiringEntries as $entry) {
            // Enviamos una notificación por cada lote que está por vencer
            Notification::send($supervisors, new ProductExpiringSoon($entry));
            $this->info("Notificación enviada para el producto: {$entry->product->name}, Lote: {$entry->batch}");
        }

        $this->info('Revisión de vencimientos completada.');
    }
}