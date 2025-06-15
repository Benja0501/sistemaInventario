@extends('layouts.master')

@section('title', 'Ver Informe de Discrepancia')
@section('subtitle', 'Detalles del Informe #' . $discrepancy->id)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Informe de Discrepancia #{{ $discrepancy->id }}</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Fecha de Conteo</dt>
                        {{-- LÍNEA CORREGIDA CON EL OPERADOR NULL SAFE --}}
                        <dd class="col-sm-9">{{ $discrepancy->count_date?->format('d/m/Y') }}</dd>

                        <dt class="col-sm-3">Registrado por</dt>
                        <dd class="col-sm-9">{{ $discrepancy->user->name ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Estado</dt>
                        <dd class="col-sm-9">
                            @if ($discrepancy->status == 'open')
                                <span class="badge badge-warning">Abierto</span>
                            @else
                                <span class="badge badge-success">Cerrado / Ajustado</span>
                            @endif
                        </dd>

                        <dt class="col-sm-3">Observaciones</dt>
                        <dd class="col-sm-9">{{ $discrepancy->general_remarks ?? 'Ninguna.' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    {{-- ... (El resto del archivo se queda igual) ... --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title">Detalles de las Discrepancias Encontradas</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Stock Sistema</th>
                                <th>Stock Físico</th>
                                <th>Diferencia</th>
                                <th>Justificación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($discrepancy->details as $detail)
                                <tr>
                                    <td>{{ $detail->product->name ?? 'N/A' }}</td>
                                    <td>{{ $detail->system_quantity }}</td>
                                    <td>{{ $detail->physical_quantity }}</td>
                                    <td>
                                        @if ($detail->difference > 0)
                                            <strong class="text-success">+{{ $detail->difference }}</strong>
                                        @else
                                            <strong class="text-danger">{{ $detail->difference }}</strong>
                                        @endif
                                    </td>
                                    <td>{{ $detail->justification ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No se encontraron discrepancias en este informe.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if ($discrepancy->status == 'open' && auth()->user()->role == 'supervisor')
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title">Procesar Informe</h4>
            </div>
            <div class="card-body">
                <p class="text-danger"><strong>Atención:</strong> Esta acción ajustará el stock de los productos para que
                    coincida con el conteo físico. Esta operación no se puede deshacer.</p>
                <form action="{{ route('discrepancies.adjust', $discrepancy) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> Aprobar y Ajustar
                        Stock</button>
                </form>
            </div>
        </div>
    @endif

    <a href="{{ route('discrepancies.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver
        al Listado</a>
@endsection
