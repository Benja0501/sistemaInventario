@extends('layouts.master')

@section('title', 'Ver Orden de Compra')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-shopping-cart"></i> Detalle Orden #{{ $purchaseOrder->order_number }}</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $purchaseOrder->id }}</dd>
                <dt class="col-sm-3">Nº Orden</dt>
                <dd class="col-sm-9">{{ $purchaseOrder->order_number }}</dd>
                <dt class="col-sm-3">Proveedor</dt>
                <dd class="col-sm-9">{{ $purchaseOrder->supplier->business_name }}</dd>
                <dt class="col-sm-3">Creada Por</dt>
                <dd class="col-sm-9">{{ $purchaseOrder->creator->name }}</dd>
                <dt class="col-sm-3">Fecha Orden</dt>
                <dd class="col-sm-9">{{ $purchaseOrder->order_date?->format('d/m/Y H:i') }}</dd>
                <dt class="col-sm-3">Entrega Esperada</dt>
                <dd class="col-sm-9">{{ $purchaseOrder->expected_delivery_date?->format('d/m/Y') }}</dd>
                <dt class="col-sm-3">Total</dt>
                <dd class="col-sm-9">
                    {{ number_format($purchaseOrder->total_amount, 2) }}
                </dd>
                <dt class="col-sm-3">Estado</dt>
                <dd class="col-sm-9">
                    <span
                        class="badge badge-{{ match ($purchaseOrder->status) {
                            'pending' => 'secondary',
                            'approved' => 'primary',
                            'rejected' => 'danger',
                            'sent' => 'info',
                            'partial_received' => 'warning',
                            'completed' => 'success',
                            'canceled' => 'dark',
                            default => 'secondary',
                        } }}">{{ ucfirst(str_replace('_', ' ', $purchaseOrder->status)) }}</span>
                </dd>
            </dl>

            <h5>Items</h5>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cant.</th>
                        <th>Precio Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchaseOrder->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->unit_price, 2) }}</td>
                            <td>{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection
