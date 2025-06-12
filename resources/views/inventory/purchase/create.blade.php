@extends('layouts.master')

@section('title', 'Nueva Orden de Compra')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-shopping-cart"></i> Nueva Orden</h3>
        </div>
        <div class="card-body">
            <form id="purchase-form" action="{{ route('purchases.store') }}" method="POST">
                @csrf

                {{-- Encabezado --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="order_number">Nº de Orden</label>
                        <input type="text" name="order_number" id="order_number"
                            class="form-control @error('order_number') is-invalid @enderror"
                            value="{{ old('order_number') }}" required>
                        @error('order_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="created_by_user_id">Creada Por</label>
                        <select name="created_by_user_id" id="created_by_user_id"
                            class="form-control @error('created_by_user_id') is-invalid @enderror" required>
                            <option value="">-- Usuario --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('created_by_user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('created_by_user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="supplier_id">Proveedor</label>
                        <select name="supplier_id" id="supplier_id"
                            class="form-control @error('supplier_id') is-invalid @enderror" required>
                            <option value="">-- Proveedor --</option>
                            @foreach ($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                    {{ $sup->business_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="order_date">Fecha Orden</label>
                        <input type="date" name="order_date" id="order_date"
                            class="form-control @error('order_date') is-invalid @enderror" value="{{ old('order_date') }}">
                        @error('order_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="expected_delivery_date">Fecha Esperada</label>
                        <input type="date" name="expected_delivery_date" id="expected_delivery_date"
                            class="form-control @error('expected_delivery_date') is-invalid @enderror"
                            value="{{ old('expected_delivery_date') }}">
                        @error('expected_delivery_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="status">Estado</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                            required>
                            @foreach (['pending' => 'Pendiente', 'approved' => 'Aprobada', 'rejected' => 'Rechazada', 'sent' => 'Enviada', 'partial_received' => 'Parcial', 'completed' => 'Completada', 'canceled' => 'Cancelada'] as $key => $label)
                                <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Ítems --}}
                <div class="mb-3">
                    <h5>Ítems</h5>
                    <table class="table table-sm table-bordered" id="items-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th style="width:100px">Cant.</th>
                                <th style="width:120px">Precio Unit.</th>
                                <th style="width:120px">Subtotal</th>
                                <th style="width:50px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- fila inicial --}}
                            <tr class="item-row">
                                <td>
                                    <select name="items[0][product_id]" class="form-control product-select" required>
                                        <option value="">--</option>
                                        @foreach ($products as $p)
                                            <option value="{{ $p->id }}" data-price="{{ $p->unit_price }}">
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="items[0][quantity]" class="form-control qty-input"
                                        min="1" value="1" required></td>
                                <td><input type="number" name="items[0][unit_price]" class="form-control price-input"
                                        step="0.01" readonly></td>
                                <td><input type="text" name="items[0][subtotal]" class="form-control subtotal-input"
                                        readonly></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove-item">&times;</button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <button type="button" class="btn btn-sm btn-primary" id="add-item">
                                        <i class="fas fa-plus-circle"></i> Agregar fila
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th>
                                    <input type="text" id="total-amount" name="total_amount" class="form-control"
                                        readonly value="0.00">
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <button class="btn btn-success"><i class="fas fa-save"></i> Guardar Orden</button>
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                    Cancelar</a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/purchase_form.js') }}"></script>
@endsection
