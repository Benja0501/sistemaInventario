<div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formItem" method="POST" action="">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemModalLabel">Agregar Ítem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Producto</label>
                        <select id="product_id" name="product_id" class="form-control">
                            <option value="">-- Seleccione --</option>
                            @foreach ($products as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Cantidad</label>
                        <input type="number" id="quantity" name="quantity" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="unit_price" class="form-label">Precio Unit.</label>
                        <input type="number" step="0.01" id="unit_price" name="unit_price" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
