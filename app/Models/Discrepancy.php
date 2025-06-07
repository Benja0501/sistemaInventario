<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discrepancy extends Model
{
    /** @use HasFactory<\Database\Factories\DiscrepancyFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'system_quantity',
        'physical_quantity',
        'discrepancy_type',
        'note',
        'evidence_path',
        'reported_by_user_id',
        'reported_at',
    ];

    protected $casts = [
        'system_quantity'       => 'integer',
        'physical_quantity'     => 'integer',
        'reported_at'           => 'datetime',
    ];

    /**
     * La discrepancia está ligada a un producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Usuario que reportó la discrepancia.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by_user_id');
    }
}
