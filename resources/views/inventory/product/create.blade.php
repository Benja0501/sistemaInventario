@extends('layouts.master')

@section('title', 'Nuevo Producto')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-box"></i> Nuevo Producto</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" name="sku" id="sku"
                            class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}" required>
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="unit_price" class="form-label">Precio Unit.</label>
                        <input type="number" step="0.01" name="unit_price" id="unit_price"
                            class="form-control @error('unit_price') is-invalid @enderror" value="{{ old('unit_price', 0) }}"
                            required>
                        @error('unit_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="min_stock" class="form-label">Stock Mín.</label>
                        <input type="number" name="min_stock" id="min_stock"
                            class="form-control @error('min_stock') is-invalid @enderror" value="{{ old('min_stock', 0) }}"
                            required>
                        @error('min_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="current_stock" class="form-label">Stock Actual</label>
                        <input type="number" name="current_stock" id="current_stock"
                            class="form-control @error('current_stock') is-invalid @enderror"
                            value="{{ old('current_stock', 0) }}" required>
                        @error('current_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="unit_of_measure" class="form-label">U. Medida</label>
                        <input type="text" name="unit_of_measure" id="unit_of_measure"
                            class="form-control @error('unit_of_measure') is-invalid @enderror"
                            value="{{ old('unit_of_measure') }}" required>
                        @error('unit_of_measure')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Categoría</label>
                        <select name="category_id" id="category_id"
                            class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">-- Seleccione --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Estado</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                            required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Activo</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
@endsection
