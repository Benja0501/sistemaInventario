@extends('layouts.master')

@section('title', 'Nuevo Lote')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-layer-group"></i> Nuevo Lote</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('batches.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="product_id">Producto</label>
                        <select name="product_id" id="product_id"
                            class="form-control @error('product_id') is-invalid @enderror" required>
                            <option value="">-- Seleccione --</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="batch_number">Número de Lote</label>
                        <input type="text" name="batch_number" id="batch_number"
                            class="form-control @error('batch_number') is-invalid @enderror"
                            value="{{ old('batch_number') }}">
                        @error('batch_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="expiration_date">Fecha de Vencimiento</label>
                        <input type="date" name="expiration_date" id="expiration_date"
                            class="form-control @error('expiration_date') is-invalid @enderror"
                            value="{{ old('expiration_date') }}">
                        @error('expiration_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="quantity">Cantidad</label>
                        <input type="number" name="quantity" id="quantity" min="0"
                            class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 0) }}"
                            required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
                <a href="{{ route('batches.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </form>
        </div>
    </div>
@endsection
