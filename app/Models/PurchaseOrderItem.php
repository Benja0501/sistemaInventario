<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseOrderItemFactory> */
    use HasFactory;
    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'quantity'   => 'integer',
        'unit_price' => 'decimal:2',
    ];

    /**
     * El ítem pertenece a una orden de compra.
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    /**
     * El ítem referencia a un producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
