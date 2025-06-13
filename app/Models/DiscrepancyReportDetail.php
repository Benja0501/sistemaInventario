<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscrepancyReportDetail extends Model
{
    /** @use HasFactory<\Database\Factories\DiscrepancyReportDetailFactory> */
    use HasFactory;
    protected $fillable = [
        'discrepancy_report_id',
        'product_id',
        'system_quantity',
        'physical_quantity',
        'difference',
        'justification',
    ];

    /**
     * Relación: El detalle pertenece a un producto.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
