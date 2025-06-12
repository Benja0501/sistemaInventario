@extends('layouts.master')

@section('title', 'Ver Categoría')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-tags"></i> Detalle Categoría</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $category->id }}</dd>

                <dt class="col-sm-3">Nombre</dt>
                <dd class="col-sm-9">{{ $category->name }}</dd>

                <dt class="col-sm-3">Descripción</dt>
                <dd class="col-sm-9">{{ $category->description }}</dd>

                <dt class="col-sm-3">Creado</dt>
                <dd class="col-sm-9">{{ $category->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Actualizado</dt>
                <dd class="col-sm-9">{{ $category->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>

            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline"
                onsubmit="return confirm('¿Eliminar categoría?');">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </form>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection
