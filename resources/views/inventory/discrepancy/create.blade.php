@extends('layouts.master')

@section('title', 'Nuevo Informe de Discrepancia')
@section('subtitle', 'Registro de conteo físico de inventario')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Conteo Físico</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('discrepancies.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="count_date">Fecha del Conteo</label>
                        <input type="date" name="count_date"
                            class="form-control @error('count_date') is-invalid @enderror"
                            value="{{ old('count_date', date('Y-m-d')) }}" required>
                        @error('count_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="general_remarks">Observaciones Generales</label>
                    <textarea name="general_remarks" class="form-control">{{ old('general_remarks') }}</textarea>
                </div>

                <hr>
                <h4 class="mb-3">Registro de Cantidades Físicas</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th style="width: 15%;">Stock Sistema</th>
                                <th style="width: 15%;">Cantidad Física</th>
                                <th style="width: 15%;">Diferencia</th>
                                <th>Justificación (Si hay diferencia)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        {{ $product->name }}
                                        <input type="hidden" name="details[{{ $loop->index }}][product_id]"
                                            value="{{ $product->id }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control system-stock"
                                            value="{{ $product->stock }}" readonly>
                                    </td>
                                    <td>
                                        <input type="number" name="details[{{ $loop->index }}][physical_quantity]"
                                            class="form-control physical-quantity"
                                            value="{{ old('details.' . $loop->index . '.physical_quantity', $product->stock) }}"
                                            min="0" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control difference" readonly>
                                    </td>
                                    <td>
                                        <input type="text" name="details[{{ $loop->index }}][justification]"
                                            class="form-control">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{ route('discrepancies.index') }}" class="btn btn-secondary"><i
                            class="fas fa-arrow-left"></i> Cancelar</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Informe</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para calcular la diferencia para una fila
            function calculateDifference(row) {
                const systemStock = parseInt(row.querySelector('.system-stock').value) || 0;
                const physicalQuantity = parseInt(row.querySelector('.physical-quantity').value) || 0;
                const difference = physicalQuantity - systemStock;
                const diffInput = row.querySelector('.difference');

                diffInput.value = difference;
                // Cambiar color según la diferencia
                diffInput.classList.remove('text-success', 'text-danger');
                if (difference > 0) {
                    diffInput.classList.add('text-success');
                    diffInput.value = '+' + difference;
                } else if (difference < 0) {
                    diffInput.classList.add('text-danger');
                }
            }

            // Calcular todas las diferencias al cargar la página
            document.querySelectorAll('.physical-quantity').forEach(input => {
                calculateDifference(input.closest('tr'));
            });

            // Añadir listener para recalcular cuando cambie una cantidad física
            document.querySelector('tbody').addEventListener('input', function(e) {
                if (e.target.classList.contains('physical-quantity')) {
                    calculateDifference(e.target.closest('tr'));
                }
            });
        });
    </script>
@endpush
