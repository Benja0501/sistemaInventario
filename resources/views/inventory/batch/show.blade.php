@extends('layouts.master')

@section('title', 'Ver Lote')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-layer-group"></i> Lote #{{ $batch->id }}</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Producto</dt>
                <dd class="col-sm-9">{{ $batch->product->name }}</dd>

                <dt class="col-sm-3">Número de Lote</dt>
                <dd class="col-sm-9">{{ $batch->batch_number }}</dd>

                <dt class="col-sm-3">Vencimiento</dt>
                <dd class="col-sm-9">{{ $batch->expiration_date?->format('d/m/Y') ?? '—' }}</dd>

                <dt class="col-sm-3">Cantidad</dt>
                <dd class="col-sm-9">{{ $batch->quantity }}</dd>

                <dt class="col-sm-3">Creado</dt>
                <dd class="col-sm-9">{{ $batch->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Actualizado</dt>
                <dd class="col-sm-9">{{ $batch->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
            <a href="{{ route('batches.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection
