{{-- resources/views/inventory/users/show.blade.php --}}
@extends('layouts.master')

@section('title', 'Ver Usuario')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 class="card-title mb-4">Detalle de Usuario</h2>

            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $user->id }}</dd>

                <dt class="col-sm-3">Nombre</dt>
                <dd class="col-sm-9">{{ $user->name }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>

                <dt class="col-sm-3">Rol</dt>
                <dd class="col-sm-9">{{ optional($user->role)->name ?? 'Sin asignar' }}</dd>

                <dt class="col-sm-3">Registrado el</dt>
                <dd class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i') }}</dd>
            </dl>

            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                onsubmit="return confirm('¿Eliminar usuario?');">
                @csrf @method('DELETE')
                <button class="btn btn-danger">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </form>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection
