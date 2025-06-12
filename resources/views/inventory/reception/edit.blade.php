@extends('layouts.master')

@section('title', 'Editar Recepción')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-receipt"></i> Editar Recepción #{{ $reception->id }}</h3>
        </div>
        <div class="card-body">
            <form id="reception-form" action="{{ route('receptions.update', $reception) }}" method="POST">
                @csrf @method('PUT')

                {{-- mismo bloque de encabezado que en create, usando old(...,$reception->campo) --}}

                <div class="mb-3">
                    <label for="status">Estado</label>
                    <select name="status" id="status" class="form-control">
                        @foreach (['pending' => 'Pendiente', 'partial' => 'Parcial', 'completed' => 'Completada', 'canceled' => 'Cancelada'] as $k => $lbl)
                            <option value="{{ $k }}" {{ $reception->status === $k ? 'selected' : '' }}>
                                {{ $lbl }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <h5>Ítems recibidos</h5>
                <table class="table table-sm table-bordered" id="rec-items-table">
                    <thead>…</thead>
                    <tbody>
                        @foreach ($reception->items as $it)
                            <tr class="item-row">
                                <td><input type="text" class="form-control prod-name" value="{{ $it->product->name }}"
                                        readonly></td>
                                <td><input type="number" class="form-control ord-qty"
                                        value="{{ $it->reception->purchaseOrder->items->firstWhere('id', $it->id)->quantity ?? 0 }}"
                                        readonly></td>
                                <td><input type="number" class="form-control rec-qty"
                                        name="items[{{ $it->id }}][quantity_received]"
                                        value="{{ $it->quantity_received }}" min="0"></td>
                                <td><input type="number" class="form-control dam-qty"
                                        name="items[{{ $it->id }}][quantity_damaged]"
                                        value="{{ $it->quantity_damaged }}" min="0"></td>
                                <td><input type="number" class="form-control miss-qty" readonly></td>
                                <td class="text-center">
                                    <button type="button"
                                        class="btn btn-sm btn-danger btn-remove-rec-item">&times;</button>
                                </td>
                            </tr>
                        @endforeach
                        {{-- plantilla .d-none al final --}}
                        <tr class="item-row d-none">…igual que en create…</tr>
                    </tbody>
                </table>

                <button class="btn btn-info mt-3"><i class="fas fa-save"></i> Actualizar</button>
                <a href="{{ route('receptions.index') }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i>
                    Volver</a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/reception.js') }}"></script>
@endsection
