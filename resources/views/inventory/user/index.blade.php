@extends('layouts.master')

@section('title', 'Usuarios')
@section('subtitle', 'Gestión de usuarios del sistema')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Listado de Usuarios</h3>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Nuevo Usuario
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="users-table" class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            {{-- 1. COLUMNA AÑADIDA --}}
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                {{-- 2. CAMBIO EN LA FORMA DE MOSTRAR EL ROL --}}
                                <td>{{ ucfirst($user->role) }}</td>

                                {{-- 1. COLUMNA AÑADIDA --}}
                                <td class="text-center">
                                    @if ($user->status == 'active')
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-primary"
                                        title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- 3. MEJORA DE SEGURIDAD Y CLARIDAD EN LA ACCIÓN --}}
                                    {{-- El usuario no puede desactivarse a sí mismo --}}
                                    @if (auth()->id() !== $user->id)
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('¿Estás seguro de que deseas DESACTIVAR a este usuario? Ya no podrá iniciar sesión.')">
                                            @csrf
                                            @method('DELETE')
                                            {{-- El texto ahora es más claro sobre la acción real --}}
                                            <button class="btn btn-sm btn-outline-danger" title="Desactivar">
                                                <i class="fas fa-user-slash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                {{-- Ajustamos el colspan para la nueva columna --}}
                                <td colspan="6" class="text-center py-4">
                                    No hay usuarios registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Solo muestra la paginación si hay suficientes registros --}}
        @if ($users->hasPages())
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection
