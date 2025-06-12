@extends('layouts.master')

@section('title', 'Ver Discrepancia')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-exclamation-triangle"></i> Discrepancia #{{ $discrepancy->id }}</h3>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Producto</dt>
                <dd class="col-sm-9">{{ $discrepancy->product->name }}</dd>

                <dt class="col-sm-3">Cantidad Sistema</dt>
                <dd class="col-sm-9">{{ $discrepancy->system_quantity }}</dd>

                <dt class="col-sm-3">Cantidad Física</dt>
                <dd class="col-sm-9">{{ $discrepancy->physical_quantity }}</dd>

                <dt class="col-sm-3">Tipo</dt>
                <dd class="col-sm-9">{{ ucfirst($discrepancy->discrepancy_type) }}</dd>

                <dt class="col-sm-3">Nota</dt>
                <dd class="col-sm-9">{{ $discrepancy->note }}</dd>

                <dt class="col-sm-3">Evidencia</dt>
                <dd class="col-sm-9">
                    @if ($discrepancy->evidence_path)
                        <a href="{{ asset('storage/' . $discrepancy->evidence_path) }}" target="_blank">Ver archivo</a>
                    @else
                        —
                    @endif
                </dd>

                <dt class="col-sm-3">Reportado Por</dt>
                <dd class="col-sm-9">{{ optional($discrepancy->reporter)->name }}</dd>

                <dt class="col-sm-3">Fecha Reporte</dt>
                <dd class="col-sm-9">{{ $discrepancy->reported_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Estado</dt>
                <dd class="col-sm-9">{{ ucfirst($discrepancy->status) }}</dd>
            </dl>

            <a href="{{ route('discrepancies.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@endsection
