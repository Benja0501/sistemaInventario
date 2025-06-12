@extends('layouts.master')

@section('title', 'Roles')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-user-shield"></i> Roles</h3>
            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle"></i> Nuevo Rol
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="roles-table" class="table table-striped table-hover table-bordered w-100 mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Permisos</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    {{-- Muestra las llaves del JSON de permissions --}}
                                    @if (is_array($role->permissions))
                                        {{ implode(', ', array_keys($role->permissions)) }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-outline-primary"
                                        title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-outline-warning"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="fntPermisos({{ $role->id }});" class="btn btn-sm btn-outline-info"
                                        title="Permisos">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('¿Eliminar rol?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">No hay roles definidos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Aquí se inyectará el modal de permisos --}}
    <div id="contentAjax"></div>
@endsection
