@extends('layouts.master')

@section('title', 'Productos')
@section('subtitle', 'Listado de productos')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Listado de Productos</h3>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Nuevo Producto
            </a>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table id="products-table" class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>SKU</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->sku ?? 'N/A' }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'Sin categoría' }}</td>
                                <td class="text-center">
                                    @if ($product->stock <= $product->minimum_stock)
                                        <span class="badge badge-danger">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge badge-success">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($product->status == 'active')
                                        <span class="badge badge-success">Activo</span>
                                    @elseif ($product->status == 'inactive')
                                        <span class="badge badge-danger">Inactivo</span>
                                    @else
                                        <span class="badge badge-warning">Descontinuado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary"
                                        title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-warning"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('¿Estás seguro? Si el producto tiene historial de movimientos, será DESACTIVADO. De lo contrario, será ELIMINADO.')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Desactivar o Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    No hay productos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($products->hasPages())
            <div class="card-footer">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
