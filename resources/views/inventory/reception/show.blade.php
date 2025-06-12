@extends('layouts.master')

@section('title', 'Ver Recepción')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-receipt"></i> Recepción #{{ $reception->id }}</h3>
        </div>
        <div class="card-body">
            {{-- cabecera datos de la recepción --}}
            <dl class="row">
                <dt class="col-sm-3">Orden</dt>
                <dd class="col-sm-9">{{ $reception->purchaseOrder->order_number }}</dd>
                <dt class="col-sm-3">Recibido Por</dt>
                <dd class="col-sm-9">{{ $reception->receiver->name }}</dd>
                <dt class="col-sm-3">Fecha</dt>
                <dd class="col-sm-9">{{ $reception->received_at->format('d/m/Y H:i') }}</dd>
                <dt class="col-sm-3">Estado</dt>
                <dd class="col-sm-9">{{ ucfirst($reception->status) }}</dd>
            </dl>

            <h5>Detalle de Ítems</h5>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cant. Ordenada</th>
                        <th>Cant. Recibida</th>
                        <th>Cant. Dañada</th>
                        <th>Cant. Faltante</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reception->items as $it)
                        @php
                            // encuentra cantidad ordenada original
                            $ord = $reception->purchaseOrder->items->first(fn($x) => $x->product_id == $it->product_id)
                                ->quantity;
                            $miss = $ord - $it->quantity_received - $it->quantity_damaged;
                        @endphp
                        <tr>
                            <td>{{ $it->product->name }}</td>
                            <td>{{ $ord }}</td>
                            <td>{{ $it->quantity_received }}</td>
                            <td>{{ $it->quantity_damaged }}</td>
                            <td>{{ $miss }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('receptions.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection
