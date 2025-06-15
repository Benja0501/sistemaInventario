@extends('layouts.master')

@section('title', 'Informes de Discrepancia')
@section('subtitle', 'Historial de conteos y ajustes de inventario')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Historial de Informes de Discrepancia</h3>
            @if (in_array(auth()->user()->role, ['supervisor', 'warehouse']))
                <a href="{{ route('discrepancies.create') }}" class="btn btn-warning">
                    <i class="fas fa-plus-circle"></i> Nuevo Informe de Conteo
                </a>
            @endif
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table id="discrepancies-table" class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Conteo</th>
                            <th>Registrado por</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td>#{{ $report->id }}</td>
                                <td>{{ $report->count_date->format('d/m/Y') }}</td>
                                <td>{{ $report->user->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if ($report->status == 'open')
                                        <span class="badge badge-warning">Abierto</span>
                                    @else
                                        <span class="badge badge-success">Cerrado / Ajustado</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('discrepancies.show', $report) }}"
                                        class="btn btn-sm btn-outline-primary" title="Ver y Procesar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No hay informes de discrepancia registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($reports->hasPages())
            <div class="card-footer">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
@endsection
