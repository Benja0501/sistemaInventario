@extends('layouts.master')

@section('title', 'Ver Producto')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-box"></i> Detalle Producto</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $product->id }}</dd>
                <dt class="col-sm-3">SKU</dt>
                <dd class="col-sm-9">{{ $product->sku }}</dd>
                <dt class="col-sm-3">Nombre</dt>
                <dd class="col-sm-9">{{ $product->name }}</dd>
                <dt class="col-sm-3">Descripción</dt>
                <dd class="col-sm-9">{{ $product->description }}</dd>
                <dt class="col-sm-3">Precio Unit.</dt>
                <dd class="col-sm-9">{{ number_format($product->unit_price, 2) }}</dd>
                <dt class="col-sm-3">Stock Actual</dt>
                <dd class="col-sm-9">{{ $product->current_stock }}</dd>
                <dt class="col-sm-3">Stock Mín.</dt>
                <dd class="col-sm-9">{{ $product->min_stock }}</dd>
                <dt class="col-sm-3">U. Medida</dt>
                <dd class="col-sm-9">{{ $product->unit_of_measure }}</dd>
                <dt class="col-sm-3">Categoría</dt>
                <dd class="col-sm-9">{{ optional($product->category)->name ?? '-' }}</dd>
                <dt class="col-sm-3">Estado</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </dd>
                <dt class="col-sm-3">Creado</dt>
                <dd class="col-sm-9">{{ $product->created_at->format('d/m/Y H:i') }}</dd>
                <dt class="col-sm-3">Actualizado</dt>
                <dd class="col-sm-9">{{ $product->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>

            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                onsubmit="return confirm('¿Eliminar producto?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </form>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection
