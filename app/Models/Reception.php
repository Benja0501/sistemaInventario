<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    /** @use HasFactory<\Database\Factories\ReceptionFactory> */
    use HasFactory;
    protected $fillable = [
        'purchase_order_id',
        'received_by_user_id',
        'received_at',
        'status',
    ];

    protected $casts = [
        'received_at' => 'datetime',
    ];

    /**
     * La recepción pertenece a una orden de compra.
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    /**
     * El usuario que recibió la orden.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by_user_id');
    }

    /**
     * Ítems de la recepción (si implementas ReceptionItem).
     */
    public function items()
    {
        return $this->hasMany(ReceptionItem::class);
    }
}
