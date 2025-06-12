@extends('layouts.master')

@section('title', 'Productos')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-box"></i> Productos</h3>
            <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle"></i> Nuevo Producto
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="products-table" class="table table-striped table-hover table-bordered w-100 mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>SKU</th>
                            <th>Nombre</th>
                            <th>Precio Unit.</th>
                            <th>Stock Actual</th>
                            <th>Stock Mínimo</th>
                            <th>U. Medida</th>
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->sku }}</td>
                                <td>{{ $p->name }}</td>
                                <td>{{ number_format($p->unit_price, 2) }}</td>
                                <td>{{ $p->current_stock }}</td>
                                <td>{{ $p->min_stock }}</td>
                                <td>{{ $p->unit_of_measure }}</td>
                                <td>{{ optional($p->category)->name ?? '-' }}</td>
                                <td><span class="badge badge-{{ $p->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('products.show', $p) }}" class="btn btn-sm btn-outline-primary"
                                        title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-outline-warning"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $p) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('¿Eliminar producto?')">
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
                                <td colspan="10" class="text-center py-4">No hay productos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            {{ $products->links() }}
        </div>
    </div>
@endsection
