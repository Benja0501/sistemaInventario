<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLocation extends Model
{
    /** @use HasFactory<\Database\Factories\ProductLocationFactory> */
    use HasFactory;
    protected $fillable = [
        'product_id',
        'location_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * El vínculo pertenece a un producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * El vínculo pertenece a una ubicación.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
