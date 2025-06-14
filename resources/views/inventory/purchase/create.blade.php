@extends('layouts.master')

@section('title', 'Nueva Orden de Compra')
@section('subtitle', 'Registro de nueva orden')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Nueva Orden de Compra</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf
                {{-- SECCIÓN DEL PROVEEDOR --}}
                <div class="row">
                    <div class="col-md-8 form-group">
                        <label for="supplier_id">Proveedor</label>
                        <select name="supplier_id" id="supplier_id"
                            class="form-control @error('supplier_id') is-invalid @enderror" required>
                            <option value="">-- Seleccione un Proveedor --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}
                                    ({{ $supplier->ruc }})
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="remarks">Observaciones</label>
                    <textarea name="remarks" id="remarks" class="form-control">{{ old('remarks') }}</textarea>
                </div>

                <hr>

                {{-- SECCIÓN DE PRODUCTOS --}}
                <h4 class="mb-3">Detalles de la Orden</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th style="width: 15%;">Cantidad</th>
                                <th style="width: 15%;">Precio Unitario (S/)</th>
                                <th style="width: 15%;">Subtotal</th>
                                <th style="width: 5%;"></th>
                            </tr>
                        </thead>
                        <tbody id="details-body">
                            {{-- Las filas de productos se añadirán aquí con JS --}}
                        </tbody>
                    </table>
                </div>
                <button type="button" id="add-product-btn" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> Añadir
                    Producto</button>

                <hr>
                <div class="d-flex justify-content-end">
                    <h4>Total: S/ <span id="total-display">0.00</span></h4>
                </div>

                <div class="mt-4">
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                        Volver</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Orden</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Template para la fila de producto (oculto) --}}
    <template id="product-row-template">
        <tr>
            <td>
                <select name="details[__INDEX__][product_id]" class="form-control product-select" required>
                    <option value="">-- Seleccione --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->purchase_price ?? 0 }}">
                            {{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="details[__INDEX__][quantity]" class="form-control quantity-input" value="1"
                    min="1" required></td>
            <td><input type="number" name="details[__INDEX__][unit_price]" class="form-control price-input" step="0.01"
                    min="0" required></td>
            <td><input type="text" class="form-control subtotal-input" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row-btn"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    </template>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let productIndex = 0;
            const addProductBtn = document.getElementById('add-product-btn');
            const detailsBody = document.getElementById('details-body');
            const productRowTemplate = document.getElementById('product-row-template');

            addProductBtn.addEventListener('click', () => {
                // --- AQUÍ ESTÁ EL CAMBIO ---

                // 1. Obtenemos el HTML de la plantilla como un texto (string).
                let templateHtml = productRowTemplate.innerHTML;

                // 2. Reemplazamos el placeholder en ese texto. Esto funciona porque .replace() es para strings.
                let newRowHtml = templateHtml.replace(/__INDEX__/g, productIndex);

                // 3. Insertamos el nuevo HTML directamente al final del cuerpo de la tabla.
                detailsBody.insertAdjacentHTML('beforeend', newRowHtml);

                productIndex++;
            });

            // El resto de tu código para eliminar filas y calcular totales está perfecto y no necesita cambios.
            detailsBody.addEventListener('click', e => {
                if (e.target.classList.contains('remove-row-btn') || e.target.closest('.remove-row-btn')) {
                    e.target.closest('tr').remove();
                    updateTotal();
                }
            });

            detailsBody.addEventListener('change', e => {
                const tr = e.target.closest('tr');
                if (!tr) return;

                if (e.target.classList.contains('product-select')) {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    const price = selectedOption.dataset.price || 0;
                    tr.querySelector('.price-input').value = price;
                }

                updateRowSubtotal(tr);
            });

            // Función separada para actualizar el subtotal de una fila
            function updateRowSubtotal(row) {
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const subtotal = (quantity * price).toFixed(2);
                row.querySelector('.subtotal-input').value = subtotal;
                updateTotal();
            }

            function updateTotal() {
                let total = 0;
                document.querySelectorAll('#details-body tr').forEach(tr => {
                    const subtotal = parseFloat(tr.querySelector('.subtotal-input').value) || 0;
                    total += subtotal;
                });
                document.getElementById('total-display').textContent = total.toFixed(2);
            }
        });
    </script>
@endpush
