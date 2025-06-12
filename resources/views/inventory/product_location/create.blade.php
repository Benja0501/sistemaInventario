@extends('layouts.master')

@section('title', 'Nueva Ubicación de Producto')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-boxes"></i> Nueva Ubicación de Producto</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('product_locations.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="product_id" class="form-label">Producto</label>
                    <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror"
                        required>
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

                <div class="mb-3">
                    <label for="location_id" class="form-label">Ubicación</label>
                    <select name="location_id" id="location_id"
                        class="form-control @error('location_id') is-invalid @enderror" required>
                        <option value="">-- Seleccione --</option>
                        @foreach ($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id') == $loc->id ? 'selected' : '' }}>
                                {{ $loc->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('location_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Cantidad</label>
                    <input type="number" name="quantity" id="quantity" min="0"
                        class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 0) }}"
                        required>
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
                <a href="{{ route('product_locations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
@endsection
