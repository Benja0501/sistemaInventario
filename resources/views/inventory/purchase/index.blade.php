@extends('layouts.master')

@section('title', 'Órdenes de Compra')
@section('subtitle', 'Listado de órdenes de compra')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Listado de Órdenes de Compra</h3>
            {{-- Solo usuarios de Compras o Supervisores pueden crear órdenes --}}
            @if (in_array(auth()->user()->role, ['supervisor', 'purchasing']))
                <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Nueva Orden
                </a>
            @endif
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table id="purchases-table" class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                            <th class="text-right">Total</th>
                            <th class="text-center">Estado</th>
                            <th>Creado por</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchaseOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->supplier->name ?? 'N/A' }}</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="text-right">S/ {{ number_format($order->total, 2) }}</td>
                                <td class="text-center">
                                    @if ($order->status == 'pending')
                                        <span class="badge badge-warning">Pendiente</span>
                                    @elseif($order->status == 'approved')
                                        <span class="badge badge-info">Aprobada</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge badge-success">Completada</span>
                                    @elseif($order->status == 'partial_received')
                                        <span class="badge badge-primary">Recepción Parcial</span>
                                    @elseif($order->status == 'canceled')
                                        <span class="badge badge-danger">Cancelada</span>
                                    @endif
                                </td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('purchases.show', $order) }}"
                                        class="btn btn-sm btn-outline-primary" title="Ver y Gestionar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No hay órdenes de compra registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($purchaseOrders->hasPages())
            <div class="card-footer">
                {{ $purchaseOrders->links() }}
            </div>
        @endif
    </div>
@endsection
