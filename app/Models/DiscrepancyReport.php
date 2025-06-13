<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscrepancyReport extends Model
{
    /** @use HasFactory<\Database\Factories\DiscrepancyReportFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'count_date',
        'status',
        'general_remarks',
    ];

    protected $casts = [
        'count_date' => 'date',
    ];

    /**
     * Relación: El informe fue creado por un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: El informe tiene muchos detalles.
     */
    public function details()
    {
        return $this->hasMany(DiscrepancyReportDetail::class);
    }
}
