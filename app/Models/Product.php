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
        'category_id',
        'stock',
        'minimum_stock',
        'status',
        'purchase_price',
        'sale_price',
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

    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class);
    }

    public function stockExits()
    {
        return $this->hasMany(StockExit::class);
    }
}
