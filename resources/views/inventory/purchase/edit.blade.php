@extends('layouts.master')

@section('title', 'Editar Orden de Compra')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <h3><i class="fas fa-shopping-cart"></i> Editar Orden #{{ $purchaseOrder->order_number }}</h3>
        </div>
        <div class="card-body">
            <form id="purchase-form" action="{{ route('purchases.update', $purchaseOrder) }}" method="POST">
                @csrf @method('PUT')

                {{-- (mismos campos de encabezado que en create, con old(...,$purchaseOrder->campo)) --}}

                {{-- Ítems existentes + plantillas para nuevos --}}
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
                            @foreach ($purchaseOrder->items as $i => $item)
                                <tr class="item-row">
                                    <td>
                                        <select name="items[{{ $i }}][product_id]"
                                            class="form-control product-select" required>
                                            <option value="">--</option>
                                            @foreach ($products as $p)
                                                <option value="{{ $p->id }}" data-price="{{ $p->unit_price }}"
                                                    {{ $item->product_id == $p->id ? 'selected' : '' }}>
                                                    {{ $p->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="items[{{ $i }}][quantity]"
                                            class="form-control qty-input" min="1" value="{{ $item->quantity }}"
                                            required></td>
                                    <td><input type="number" name="items[{{ $i }}][unit_price]"
                                            class="form-control price-input" step="0.01" value="{{ $item->unit_price }}"
                                            readonly></td>
                                    <td><input type="text" name="items[{{ $i }}][subtotal]"
                                            class="form-control subtotal-input" readonly
                                            value="{{ number_format($item->quantity * $item->unit_price, 2) }}"></td>
                                    <td class="text-center">
                                        <button type="button"
                                            class="btn btn-sm btn-danger btn-remove-item">&times;</button>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- fila vacía para clonar --}}
                            <tr class="item-row d-none">
                                <td>
                                    <select class="form-control product-select">
                                        <option value="">--</option>
                                        @foreach ($products as $p)
                                            <option value="{{ $p->id }}" data-price="{{ $p->unit_price }}">
                                                {{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" class="form-control qty-input" min="1" value="1"></td>
                                <td><input type="number" class="form-control price-input" step="0.01" readonly></td>
                                <td><input type="text" class="form-control subtotal-input" readonly></td>
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
                                        readonly value="{{ number_format($purchaseOrder->total_amount, 2) }}">
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <button class="btn btn-info"><i class="fas fa-save"></i> Actualizar Orden</button>
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                    Volver</a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/purchase_form.js') }}"></script>
@endsection
