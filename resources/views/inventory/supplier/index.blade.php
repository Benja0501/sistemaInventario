@extends('layouts.master')

@section('title', 'Proveedores')
@section('subtitle', 'Listado de proveedores')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Listado de Proveedores</h3>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Nuevo Proveedor
            </a>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table id="suppliers-table" class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>RUC</th>
                            <th>Teléfono</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->id }}</td>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->ruc }}</td>
                                <td>{{ $supplier->phone ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if ($supplier->status == 'active')
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('suppliers.show', $supplier) }}"
                                        class="btn btn-sm btn-outline-primary" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('suppliers.edit', $supplier) }}"
                                        class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('¿Estás seguro de que deseas DESACTIVAR a este proveedor?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Desactivar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No hay proveedores registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($suppliers->hasPages())
            <div class="card-footer">
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>
@endsection
