@extends('layouts.master')

@section('title', 'Nueva Entrada Manual')
@section('subtitle', 'Registrar ingreso de stock por ajuste o devolución')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Entrada Manual de Stock</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('entries.store') }}" method="POST">
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
                            <div class="col-md-4 form-group">
                                <label for="quantity">Cantidad a Ingresar</label>
                                <input type="number" name="quantity" id="quantity"
                                    class="form-control @error('quantity') is-invalid @enderror"
                                    value="{{ old('quantity') }}" min="1" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="batch">Lote (Opcional)</label>
                                <input type="text" name="batch" id="batch"
                                    class="form-control @error('batch') is-invalid @enderror" value="{{ old('batch') }}">
                                @error('batch')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="expiration_date">Fecha de Vencimiento (Opcional)</label>
                                <input type="date" name="expiration_date" id="expiration_date"
                                    class="form-control @error('expiration_date') is-invalid @enderror"
                                    value="{{ old('expiration_date') }}">
                                @error('expiration_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reason">Motivo de la Entrada (ej: Devolución interna, ajuste de conteo)</label>
                            <textarea name="reason" id="reason" class="form-control @error('reason') is-invalid @enderror" rows="2">{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('entries.index') }}" class="btn btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Cancelar</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar
                                Entrada</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
