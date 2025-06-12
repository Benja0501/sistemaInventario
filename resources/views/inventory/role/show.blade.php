@extends('layouts.master')

@section('title', 'Ver Rol')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user-shield"></i> Detalle de Rol</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $role->id }}</dd>

                <dt class="col-sm-3">Nombre</dt>
                <dd class="col-sm-9">{{ $role->name }}</dd>

                <dt class="col-sm-3">Creado</dt>
                <dd class="col-sm-9">{{ $role->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Actualizado</dt>
                <dd class="col-sm-9">{{ $role->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
            <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">Editar</a>
        </div>
    </div>
@endsection
