@extends('layouts.master')

@section('title', 'Ver Producto')
@section('subtitle', 'Detalles del producto')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $product->name }}</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">SKU / Código</dt>
                        <dd class="col-sm-8">{{ $product->sku ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Descripción</dt>
                        <dd class="col-sm-8">{{ $product->description ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Categoría</dt>
                        <dd class="col-sm-8">{{ $product->category->name ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Stock Actual</dt>
                        <dd class="col-sm-8">{{ $product->stock }} unidades</dd>

                        <dt class="col-sm-4">Stock Mínimo</dt>
                        <dd class="col-sm-8">{{ $product->minimum_stock }} unidades</dd>

                        <dt class="col-sm-4">Precio Venta</dt>
                        <dd class="col-sm-8">S/ {{ number_format($product->sale_price, 2) }}</dd>

                        <dt class="col-sm-4">Precio Compra (Ref.)</dt>
                        <dd class="col-sm-8">S/ {{ number_format($product->purchase_price, 2) }}</dd>

                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8">
                            @if ($product->status == 'active')
                                <span class="badge badge-success">Activo</span>
                            @elseif ($product->status == 'inactive')
                                <span class="badge badge-danger">Inactivo</span>
                            @else
                                <span class="badge badge-warning">Descontinuado</span>
                            @endif
                        </dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                        Volver</a>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning"><i class="fas fa-edit"></i>
                        Editar</a>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Movimientos Recientes</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentMovements as $movement)
                                    <tr>
                                        <td>{{ $movement->created_at->format('d/m/y H:i') }}</td>
                                        <td>
                                            @if ($movement->type === 'entry')
                                                <span class="badge badge-success">Entrada</span>
                                            @else
                                                <span class="badge badge-warning">Salida</span>
                                            @endif
                                        </td>
                                        <td>{{ $movement->quantity }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No hay movimientos para este producto.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
