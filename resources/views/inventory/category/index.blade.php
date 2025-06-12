@extends('layouts.master')

@section('title', 'Categorías')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-tags"></i> Categorías</h3>
            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle"></i> Nueva Categoría
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="categories-table" class="table table-striped table-hover table-bordered w-100 mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                            <tr>
                                <td>{{ $cat->id }}</td>
                                <td>{{ $cat->name }}</td>
                                <td>{{ $cat->description }}</td>
                                <td class="text-center">
                                    <a href="{{ route('categories.show', $cat) }}" class="btn btn-sm btn-outline-primary"
                                        title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-outline-warning"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('¿Eliminar categoría?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">No hay categorías registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
