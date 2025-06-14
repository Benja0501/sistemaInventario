@extends('layouts.master')

@section('title', 'Ver Categoría')
@section('subtitle', 'Detalles de la categoría')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles de la Categoría: {{ $category->name }}</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">ID</dt>
                        <dd class="col-sm-9">{{ $category->id }}</dd>

                        <dt class="col-sm-3">Nombre</dt>
                        <dd class="col-sm-9">{{ $category->name }}</dd>

                        <dt class="col-sm-3">Descripción</dt>
                        <dd class="col-sm-9">{{ $category->description ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Estado</dt>
                        <dd class="col-sm-9">
                            @if ($category->status == 'active')
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </dd>

                        <dt class="col-sm-3">Registrado el</dt>
                        <dd class="col-sm-9">{{ $category->created_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                        Volver</a>
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning"><i class="fas fa-edit"></i>
                        Editar</a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Productos en esta Categoría ({{ $category->products->count() }})</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($category->products as $product)
                            <li class="list-group-item">
                                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                <span class="float-right">Stock: {{ $product->stock }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center">No hay productos asociados a esta categoría.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
