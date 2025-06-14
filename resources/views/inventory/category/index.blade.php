@extends('layouts.master')

@section('title', 'Categorías')
@section('subtitle', 'Listado de categorías de productos')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Listado de Categorías</h3>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Nueva Categoría
            </a>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Nº de Productos</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td class="text-center">
                                    @if ($category->status == 'active')
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $category->products_count }}</td>
                                <td class="text-center">
                                    <a href="{{ route('categories.show', $category) }}"
                                        class="btn btn-sm btn-outline-primary" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('categories.edit', $category) }}"
                                        class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('¿Estás seguro? Esta acción no se puede realizar si la categoría tiene productos asociados.')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No hay categorías registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($categories->hasPages())
            <div class="card-footer">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@endsection
