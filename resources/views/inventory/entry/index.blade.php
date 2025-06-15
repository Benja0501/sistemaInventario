@extends('layouts.master')

@section('title', 'Entradas de Stock')
@section('subtitle', 'Historial de ingresos de mercadería')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Historial de Entradas de Stock</h3>
            @if (in_array(auth()->user()->role, ['supervisor', 'warehouse']))
                {{-- MEJORA 3: Ruta estandarizada --}}
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
                            {{-- MEJORA 1: Columna de Acciones --}}
                            <th class="text-center">Acciones</th>
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
                                        {{-- El nombre de la ruta es 'purchases.show' según tu archivo de rutas --}}
                                        <a href="{{ route('purchases.show', $entry->purchase_order_id) }}">Orden
                                            #{{ $entry->purchase_order_id }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $entry->batch ?? 'N/A' }}</td>
                                <td>
                                    {{-- MEJORA 2: Resaltado de fechas de vencimiento --}}
                                    @if ($entry->expiration_date)
                                        @if ($entry->expiration_date->isPast())
                                            <span
                                                class="badge badge-danger">{{ $entry->expiration_date->format('d/m/Y') }}</span>
                                        @elseif($entry->expiration_date->diffInDays(now()) <= 30)
                                            <span
                                                class="badge badge-warning">{{ $entry->expiration_date->format('d/m/Y') }}</span>
                                        @else
                                            {{ $entry->expiration_date->format('d/m/Y') }}
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $entry->user->name ?? 'N/A' }}</td>
                                {{-- MEJORA 1: Botón de Ver --}}
                                <td class="text-center">
                                    <a href="{{ route('entries.show', $entry) }}"
                                        class="btn btn-sm btn-outline-primary" title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
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
