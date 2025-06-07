<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceptionItem extends Model
{
    /** @use HasFactory<\Database\Factories\ReceptionItemFactory> */
    use HasFactory;
    protected $fillable = [
        'reception_id',
        'product_id',
        'quantity_received',
        'quantity_missing',
        'quantity_damaged',
    ];

    protected $casts = [
        'quantity_received' => 'integer',
        'quantity_missing'  => 'integer',
        'quantity_damaged'  => 'integer',
    ];

    /**
     * El ítem pertenece a una recepción.
     */
    public function reception()
    {
        return $this->belongsTo(Reception::class);
    }

    /**
     * El ítem referencia a un producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
