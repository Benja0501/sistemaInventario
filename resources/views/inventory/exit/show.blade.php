@extends('layouts.master')

@section('title', 'Detalle de Salida de Stock')
@section('subtitle', 'Información del registro de salida #' . $stockExit->id)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles de la Salida #{{ $stockExit->id }}</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">ID de Registro</dt>
                        <dd class="col-sm-9">{{ $stockExit->id }}</dd>

                        <dt class="col-sm-3">Producto</dt>
                        <dd class="col-sm-9">{{ $stockExit->product->name ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Cantidad Retirada</dt>
                        <dd class="col-sm-9"><strong class="text-danger">-{{ $stockExit->quantity }}</strong> unidades</dd>

                        <dt class="col-sm-3">Tipo de Salida</dt>
                        <dd class="col-sm-9">{{ $stockExit->type }}</dd>

                        <dt class="col-sm-3">Motivo / Razón</dt>
                        <dd class="col-sm-9">{{ $stockExit->reason ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Fecha de Salida</dt>
                        <dd class="col-sm-9">{{ $stockExit->exited_at->format('d/m/Y H:i:s') }}</dd>

                        <dt class="col-sm-3">Registrado por</dt>
                        <dd class="col-sm-9">{{ $stockExit->user->name ?? 'N/A' }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('exits.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                        Volver al Historial</a>
                </div>
            </div>
        </div>
    </div>
@endsection
