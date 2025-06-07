<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    /** @use HasFactory<\Database\Factories\BatchFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'batch_number',
        'expiration_date',
        'quantity',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'quantity'        => 'integer',
    ];

    /**
     * Un lote pertenece a un producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
