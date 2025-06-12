{{-- resources/views/inventory/product/edit.blade.php --}}
@extends('layouts.master')

@section('title', 'Editar Producto')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-box"></i> Editar Producto</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" name="sku" id="sku"
                            class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}"
                            required>
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-8 mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="unit_price" class="form-label">Precio Unit.</label>
                        <input type="number" step="0.01" name="unit_price" id="unit_price"
                            class="form-control @error('unit_price') is-invalid @enderror"
                            value="{{ old('unit_price', $product->unit_price) }}" required>
                        @error('unit_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="min_stock" class="form-label">Stock Mín.</label>
                        <input type="number" name="min_stock" id="min_stock"
                            class="form-control @error('min_stock') is-invalid @enderror"
                            value="{{ old('min_stock', $product->min_stock) }}" required>
                        @error('min_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="current_stock" class="form-label">Stock Actual</label>
                        <input type="number" name="current_stock" id="current_stock"
                            class="form-control @error('current_stock') is-invalid @enderror"
                            value="{{ old('current_stock', $product->current_stock) }}" required>
                        @error('current_stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="unit_of_measure" class="form-label">U. Medida</label>
                        <input type="text" name="unit_of_measure" id="unit_of_measure"
                            class="form-control @error('unit_of_measure') is-invalid @enderror"
                            value="{{ old('unit_of_measure', $product->unit_of_measure) }}" required>
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
                            <option value="">-- Seleccione categoría --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
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
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Activo
                            </option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>
                                Inactivo</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
@endsection
