@extends('layouts.master')

@section('title', 'Nueva Salida Manual')
@section('subtitle', 'Registrar salida de stock por merma o ajuste')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Salida Manual de Stock</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('exits.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="product_id">Producto</label>
                            <select name="product_id" id="product_id"
                                class="form-control @error('product_id') is-invalid @enderror" required>
                                <option value="">-- Seleccione un Producto --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (Stock actual: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="quantity">Cantidad a Retirar</label>
                                <input type="number" name="quantity" id="quantity"
                                    class="form-control @error('quantity') is-invalid @enderror"
                                    value="{{ old('quantity') }}" min="1" required>
                                {{-- El error de "stock insuficiente" aparecerá aquí gracias al Form Request --}}
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="type">Tipo de Salida</label>
                                <select name="type" id="type"
                                    class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="">-- Seleccione un tipo --</option>
                                    <option value="Waste" {{ old('type') == 'Waste' ? 'selected' : '' }}>Merma /
                                        Desperdicio</option>
                                    <option value="Discrepancy Adjustment"
                                        {{ old('type') == 'Discrepancy Adjustment' ? 'selected' : '' }}>Ajuste por Faltante
                                    </option>
                                    <option value="Other" {{ old('type') == 'Other' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reason">Motivo o Razón de la Salida</label>
                            <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="2"
                                required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('exits.index') }}" class="btn btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Cancelar</a>
                            <button type="submit" class="btn btn-danger"><i class="fas fa-save"></i> Guardar
                                Salida</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
