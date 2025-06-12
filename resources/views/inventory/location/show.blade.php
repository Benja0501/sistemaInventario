@extends('layouts.master')

@section('title', 'Ver Ubicación')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-map-marker-alt"></i> Ubicación #{{ $location->id }}</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nombre</dt>
                <dd class="col-sm-9">{{ $location->name }}</dd>

                <dt class="col-sm-3">Descripción</dt>
                <dd class="col-sm-9">{{ $location->description ?: '—' }}</dd>

                <dt class="col-sm-3">Creado</dt>
                <dd class="col-sm-9">{{ $location->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Actualizado</dt>
                <dd class="col-sm-9">{{ $location->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
            <a href="{{ route('locations.edit', $location) }}" class="btn btn-sm btn-outline-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('locations.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection
