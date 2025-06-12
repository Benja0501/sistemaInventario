@extends('layouts.master')

@section('title', 'Ver Proveedor')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-truck"></i> Detalle Proveedor</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $supplier->id }}</dd>

                <dt class="col-sm-3">Razón Social</dt>
                <dd class="col-sm-9">{{ $supplier->business_name }}</dd>

                <dt class="col-sm-3">RUC / NIT</dt>
                <dd class="col-sm-9">{{ $supplier->tax_id }}</dd>

                <dt class="col-sm-3">Dirección</dt>
                <dd class="col-sm-9">{{ $supplier->address }}</dd>

                <dt class="col-sm-3">Teléfono</dt>
                <dd class="col-sm-9">{{ $supplier->phone }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $supplier->email }}</dd>

                <dt class="col-sm-3">Estado</dt>
                <dd class="col-sm-9">{{ ucfirst($supplier->status) }}</dd>

                <dt class="col-sm-3">Creado</dt>
                <dd class="col-sm-9">{{ $supplier->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Actualizado</dt>
                <dd class="col-sm-9">{{ $supplier->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>

            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline"
                onsubmit="return confirm('¿Eliminar proveedor?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </form>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection
