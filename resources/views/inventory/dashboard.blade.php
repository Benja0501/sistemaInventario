{{-- resources/views/inventory/dashboard.blade.php --}}
@extends('layouts.master')

@section('title', 'Dashboard')
@section('subtitle', 'Resumen de actividad')

@section('content')
    {{-- Fila de KPIs (Esta ya la tienes) --}}
    <div class="row">
        <div class="col-md-4">
            <div class="tile">
                <h3 class="tile-title">Órdenes Pendientes</h3>
                <div class="tile-body display-4">{{ $pendingOrders }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tile">
                <h3 class="tile-title">Recepciones Hoy</h3>
                <div class="tile-body display-4">{{ $todayReceptions }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tile">
                <h3 class="tile-title">Discrepancias Abiertas</h3>
                <div class="tile-body display-4">{{ $openDiscrepancies }}</div>
            </div>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- NUEVA FILA CON TABLAS DE DETALLE --}}
    {{-- ========================================================= --}}
    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Productos con Bajo Stock</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Stock Actual</th>
                                <th>Stock Mínimo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lowStockProductsList as $product)
                                <tr>
                                    <td>
                                        <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                    </td>
                                    <td><span class="badge badge-danger">{{ $product->stock }}</span></td>
                                    <td>{{ $product->minimum_stock }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No hay productos con bajo stock. ¡Buen trabajo!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Últimos Movimientos</h3>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentMovements as $movement)
                                <tr>
                                    <td>{{ $movement->created_at->format('d/m/y H:i') }}</td>
                                    <td>
                                        <a
                                            href="{{ route('products.show', $movement->product) }}">{{ $movement->product->name }}</a>
                                    </td>
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
                                    <td colspan="4" class="text-center">No se han registrado movimientos recientes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
