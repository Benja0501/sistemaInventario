@extends('layouts.master')

@section('title', 'Proveedores')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-truck"></i> Proveedores</h3>
            <a href="{{ route('suppliers.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle"></i> Nuevo Proveedor
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="suppliers-table" class="table table-striped table-hover table-bordered w-100 mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Razón Social</th>
                            <th>RUC / NIT</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->id }}</td>
                                <td>{{ $supplier->business_name }}</td>
                                <td>{{ $supplier->tax_id }}</td>
                                <td>{{ $supplier->address }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>{{ ucfirst($supplier->status) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-sm btn-outline-primary"
                                        title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-warning"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('¿Eliminar proveedor?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">No hay proveedores registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            {{ $suppliers->links() }}
        </div>
    </div>
@endsection
