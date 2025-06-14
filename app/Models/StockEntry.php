<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockEntry extends Model
{
    /** @use HasFactory<\Database\Factories\StockEntryFactory> */
    use HasFactory;
    protected $fillable = [
        'product_id',
        'purchase_order_id',
        'user_id',
        'quantity',
        'reason',
        'batch',
        'expiration_date',
        'received_at',
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'expiration_date' => 'date',
    ];

    /**
     * Relación: La entrada de stock pertenece a un producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relación: La entrada de stock pertenece a una orden de compra.
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    /**
     * Relación: La entrada fue registrada por un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
