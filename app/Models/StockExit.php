<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockExit extends Model
{
    /** @use HasFactory<\Database\Factories\StockExitFactory> */
    use HasFactory;
    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'type',
        'reason',
        'exited_at',
    ];

    protected $casts = [
        'exited_at' => 'datetime',
    ];

    /**
     * Relación: La salida de stock pertenece a un producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relación: La salida fue registrada por un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
