@extends('layouts.master')
@section('title', 'Órdenes de Compra')
@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-shopping-cart"></i> Órdenes de Compra</h3>
            <a href="{{ route('purchases.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle"></i> Nueva Orden
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="purchases-table" class="table table-striped table-hover table-bordered w-100 mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nº Orden</th>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Creada Por</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->order_date?->format('d/m/Y') }}</td>
                                <td>{{ $order->supplier->business_name }}</td>
                                <td>{{ $order->creator->name }}</td>
                                <td>{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span
                                        class="badge badge-{{ match ($order->status) {
                                            'pending' => 'secondary',
                                            'approved' => 'primary',
                                            'rejected' => 'danger',
                                            'sent' => 'info',
                                            'partial_received' => 'warning',
                                            'completed' => 'success',
                                            'canceled' => 'dark',
                                            default => 'secondary',
                                        } }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('purchases.show', $order) }}" class="btn btn-sm btn-outline-primary"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="{{ route('purchases.edit', $order) }}"
                                        class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('purchases.destroy', $order) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('¿Eliminar orden?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">{{ $orders->links() }}</div>
    </div>
@endsection
<script src="{{ asset('assets/js/purchase.js') }}"></script>
<script src="{{ asset('assets/js/purchase_items.js') }}"></script>
