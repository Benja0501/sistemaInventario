<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = [
        'sku',
        'name',
        'description',
        'unit_price',
        'min_stock',
        'current_stock',
        'unit_of_measure',
        'category_id',
        'status',
    ];

    protected $casts = [
        'unit_price'    => 'decimal:2',
        'min_stock'     => 'integer',
        'current_stock' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }

    public function discrepancies()
    {
        return $this->hasMany(Discrepancy::class);
    }
}
