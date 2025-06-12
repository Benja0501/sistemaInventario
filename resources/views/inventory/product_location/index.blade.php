@extends('layouts.master')

@section('title', 'Ubicación de Productos')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-boxes"></i> Ubicación de Productos</h3>
            <a href="{{ route('product_locations.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle"></i> Nueva Ubicación
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="product-locations-table" class="table table-striped table-hover table-bordered w-100 mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Ubicación</th>
                            <th>Cantidad</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productLocations as $pl)
                            <tr>
                                <td>{{ $pl->id }}</td>
                                <td>{{ $pl->product->name }}</td>
                                <td>{{ $pl->location->name }}</td>
                                <td>{{ $pl->quantity }}</td>
                                <td class="text-center">
                                    <a href="{{ route('product_locations.show', $pl) }}"
                                        class="btn btn-sm btn-outline-primary" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('product_locations.edit', $pl) }}"
                                        class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('product_locations.destroy', $pl) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger btn-delete-pl" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No hay ubicaciones de producto.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $productLocations->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/product_location.js') }}"></script>
@endsection
