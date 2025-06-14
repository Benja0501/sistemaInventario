@extends('layouts.master')

@section('title', 'Entradas de Stock')
@section('subtitle', 'Historial de ingresos de mercadería')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Historial de Entradas de Stock</h3>
            {{-- Solo usuarios de Almacén o Supervisores pueden registrar entradas manuales --}}
            @if (in_array(auth()->user()->role, ['supervisor', 'warehouse']))
                <a href="{{ route('entries.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Registrar Entrada Manual
                </a>
            @endif
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table id="stock-entries-table" class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th>Tipo</th>
                            <th>Referencia</th>
                            <th>Lote</th>
                            <th>Vencimiento</th>
                            <th>Registrado por</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockEntries as $entry)
                            <tr>
                                <td>{{ $entry->received_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $entry->product->name ?? 'N/A' }}</td>
                                <td class="text-center"><span class="badge badge-success">+{{ $entry->quantity }}</span>
                                </td>
                                <td>
                                    @if ($entry->purchase_order_id)
                                        <span class="badge badge-primary">Compra</span>
                                    @else
                                        <span class="badge badge-secondary">Manual</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($entry->purchase_order_id)
                                        <a href="{{ route('purchases.show', $entry->purchase_order_id) }}">Orden
                                            #{{ $entry->purchase_order_id }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $entry->batch ?? 'N/A' }}</td>
                                <td>{{ $entry->expiration_date?->format('d/m/Y') ?? 'N/A' }}</td>
                                <td>{{ $entry->user->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    No hay entradas de stock registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($stockEntries->hasPages())
            <div class="card-footer">
                {{ $stockEntries->links() }}
            </div>
        @endif
    </div>
@endsection
