@extends('layouts.master')

@section('title', 'Ver Usuario')
@section('subtitle', 'Detalles del usuario registrado')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles del Usuario: {{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    {{-- Usamos una lista de descripción para mostrar los datos --}}
                    <dl class="row">
                        <dt class="col-sm-3">ID</dt>
                        <dd class="col-sm-9">{{ $user->id }}</dd>

                        <dt class="col-sm-3">Nombre</dt>
                        <dd class="col-sm-9">{{ $user->name }}</dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">{{ $user->email }}</dd>

                        {{-- ========================================================= --}}
                        {{-- CAMPOS AÑADIDOS: ROL Y ESTADO --}}
                        {{-- ========================================================= --}}
                        <dt class="col-sm-3">Rol</dt>
                        <dd class="col-sm-9">{{ ucfirst($user->role) }}</dd>

                        <dt class="col-sm-3">Estado</dt>
                        <dd class="col-sm-9">
                            @if ($user->status == 'active')
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </dd>

                        <dt class="col-sm-3">Registrado el</dt>
                        <dd class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i:s') }}</dd>

                        <dt class="col-sm-3">Última Actualización</dt>
                        <dd class="col-sm-9">{{ $user->updated_at->format('d/m/Y H:i:s') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    {{-- ========================================================= --}}
                    {{-- BOTONES DE ACCIÓN MEJORADOS --}}
                    {{-- ========================================================= --}}
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al Listado
                    </a>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Usuario
                    </a>

                    {{-- El usuario no puede desactivarse a sí mismo --}}
                    @if (auth()->id() !== $user->id)
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('¿Estás seguro de que deseas DESACTIVAR a este usuario? Ya no podrá iniciar sesión.')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" title="Desactivar">
                                <i class="fas fa-user-slash"></i> Desactivar Usuario
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- Columna lateral para información adicional si quieres --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resumen de Actividad</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Órdenes de Compra Creadas
                            <span class="badge badge-primary badge-pill">{{ $stats['purchase_orders'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Entradas de Stock Registradas
                            <span class="badge badge-success badge-pill">{{ $stats['stock_entries'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Salidas de Stock Registradas
                            <span class="badge badge-warning badge-pill">{{ $stats['stock_exits'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Informes de Discrepancia
                            <span class="badge badge-danger badge-pill">{{ $stats['discrepancy_reports'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
