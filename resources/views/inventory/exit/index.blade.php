@extends('layouts.master')

@section('title', 'Salidas de Stock')
@section('subtitle', 'Historial de salidas de mercadería')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Historial de Salidas de Stock</h3>
            @if (in_array(auth()->user()->role, ['supervisor', 'warehouse']))
                <a href="{{ route('exits.create') }}" class="btn btn-danger">
                    <i class="fas fa-plus-circle"></i> Registrar Salida Manual
                </a>
            @endif
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table id="stock-exits-table" class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th>Tipo</th>
                            <th>Motivo</th>
                            <th>Registrado por</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockExits as $exit)
                            <tr>
                                <td>{{ $exit->exited_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $exit->product->name ?? 'N/A' }}</td>
                                <td class="text-center"><span class="badge badge-danger">-{{ $exit->quantity }}</span></td>
                                <td>{{ $exit->type }}</td>
                                <td>{{ $exit->reason ?? 'N/A' }}</td>
                                <td>{{ $exit->user->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    {{-- El show de esta vista es opcional, pero dejamos el botón por si se crea en el futuro --}}
                                    <a href="#" class="btn btn-sm btn-outline-primary" title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    No hay salidas de stock registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($stockExits->hasPages())
            <div class="card-footer">
                {{ $stockExits->links() }}
            </div>
        @endif
    </div>
@endsection
