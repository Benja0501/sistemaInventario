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
        'supplier_id',
        'user_id',
        'approved_by_id',
        'approved_at',
        'total',
        'status',
        'remarks',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /**
     * Relación: La orden pertenece a un proveedor.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Relación: La orden fue creada por un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: La orden fue aprobada por un usuario (supervisor).
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    /**
     * Relación: La orden tiene muchos detalles (productos).
     */
    public function details()
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }
}
