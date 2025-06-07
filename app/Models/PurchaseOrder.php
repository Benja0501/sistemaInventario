<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseOrderFactory> */
    use HasFactory;
    protected $fillable = [
        'order_number',
        'created_by_user_id',
        'supplier_id',
        'order_date',
        'expected_delivery_date',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'order_date'            => 'date',
        'expected_delivery_date'=> 'date',
        'total_amount'          => 'decimal:2',
    ];

    /**
     * Quién creó la orden.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * El proveedor de la orden.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Ítems de la orden de compra.
     */
    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
