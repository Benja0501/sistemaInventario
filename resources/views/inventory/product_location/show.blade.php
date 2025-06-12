@extends('layouts.master')

@section('title', 'Ver Ubicación de Producto')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-boxes"></i> Ubicación #{{ $productLocation->id }}</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Producto</dt>
                <dd class="col-sm-9">{{ $productLocation->product->name }}</dd>

                <dt class="col-sm-3">Ubicación</dt>
                <dd class="col-sm-9">{{ $productLocation->location->name }}</dd>

                <dt class="col-sm-3">Cantidad</dt>
                <dd class="col-sm-9">{{ $productLocation->quantity }}</dd>

                <dt class="col-sm-3">Creado</dt>
                <dd class="col-sm-9">{{ $productLocation->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Actualizado</dt>
                <dd class="col-sm-9">{{ $productLocation->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
            <a href="{{ route('product_locations.edit', $productLocation) }}" class="btn btn-sm btn-outline-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('product_locations.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection
