@extends('layouts.master')

@section('title', 'Detalle de Entrada de Stock')
@section('subtitle', 'Información del registro de entrada #' . $stockEntry->id)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles de la Entrada #{{ $stockEntry->id }}</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">ID de Registro</dt>
                        <dd class="col-sm-9">{{ $stockEntry->id }}</dd>

                        <dt class="col-sm-3">Producto</dt>
                        <dd class="col-sm-9">{{ $stockEntry->product->name ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Cantidad Ingresada</dt>
                        <dd class="col-sm-9"><strong class="text-success">+{{ $stockEntry->quantity }}</strong> unidades
                        </dd>

                        <dt class="col-sm-3">Tipo de Entrada</dt>
                        <dd class="col-sm-9">
                            @if ($stockEntry->purchase_order_id)
                                Compra (Orden #{{ $stockEntry->purchase_order_id }})
                            @else
                                Manual
                            @endif
                        </dd>

                        <dt class="col-sm-3">Motivo (Si es manual)</dt>
                        <dd class="col-sm-9">{{ $stockEntry->reason ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Lote</dt>
                        <dd class="col-sm-9">{{ $stockEntry->batch ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Fecha de Vencimiento</dt>
                        <dd class="col-sm-9">{{ $stockEntry->expiration_date?->format('d/m/Y') ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Fecha de Recepción</dt>
                        <dd class="col-sm-9">{{ $stockEntry->received_at->format('d/m/Y H:i:s') }}</dd>

                        <dt class="col-sm-3">Registrado por</dt>
                        <dd class="col-sm-9">{{ $stockEntry->user->name ?? 'N/A' }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('entries.index') }}" class="btn btn-secondary"><i
                            class="fas fa-arrow-left"></i> Volver al Historial</a>
                </div>
            </div>
        </div>
    </div>
@endsection
