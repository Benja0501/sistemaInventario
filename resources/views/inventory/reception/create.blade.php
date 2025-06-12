@extends('layouts.master')

@section('title', 'Nueva Recepción')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-receipt"></i> Nueva Recepción</h3>
        </div>
        <div class="card-body">
            <form id="reception-form" action="{{ route('receptions.store') }}" method="POST">
                @csrf

                {{-- Cabecera --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="purchase_order_id">Orden de Compra</label>
                        <select name="purchase_order_id" id="purchase_order_id"
                            class="form-control @error('purchase_order_id') is-invalid @enderror" required>
                            <option value="">-- Seleccione --</option>
                            @foreach ($orders as $o)
                                <option value="{{ $o->id }}">{{ $o->order_number }}</option>
                            @endforeach
                        </select>
                        @error('purchase_order_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="received_by_user_id">Recibido Por</label>
                        <select name="received_by_user_id" id="received_by_user_id"
                            class="form-control @error('received_by_user_id') is-invalid @enderror" required>
                            <option value="">-- Usuario --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                        @error('received_by_user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Estado --}}
                <div class="mb-3">
                    <label for="status">Estado</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                        required>
                        @foreach (['pending' => 'Pendiente', 'partial' => 'Parcial', 'completed' => 'Completada', 'canceled' => 'Cancelada'] as $k => $lbl)
                            <option value="{{ $k }}">{{ $lbl }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Detalle de Ítems --}}
                <h5>Ítems recibidos</h5>
                <table class="table table-sm table-bordered" id="rec-items-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cant. Ordenada</th>
                            <th>Cant. Recibida</th>
                            <th>Cant. Dañada</th>
                            <th>Cant. Faltante</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- plantilla oculta para clonar --}}
                        <tr class="item-row d-none">
                            <td><input type="text" class="form-control prod-name" readonly></td>
                            <td><input type="number" class="form-control ord-qty" readonly></td>
                            <td><input type="number" class="form-control rec-qty" min="0"></td>
                            <td><input type="number" class="form-control dam-qty" min="0" value="0"></td>
                            <td><input type="number" class="form-control miss-qty" readonly></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger btn-remove-rec-item">&times;</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button class="btn btn-success mt-3"><i class="fas fa-save"></i> Guardar Recepción</button>
                <a href="{{ route('receptions.index') }}" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/reception.js') }}"></script>
@endsection
