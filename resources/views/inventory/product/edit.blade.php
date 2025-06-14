@extends('layouts.master')

@section('title', 'Editar Producto')
@section('subtitle', 'Modificación de producto')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editando: {{ $product->name }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label for="name">Nombre del Producto</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $product->name) }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="sku">SKU (Código)</label>
                                <input type="text" name="sku" id="sku"
                                    class="form-control @error('sku') is-invalid @enderror"
                                    value="{{ old('sku', $product->sku) }}">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                rows="3">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="category_id">Categoría</label>
                                <select name="category_id" id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Seleccione una Categoría --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="status">Estado</label>
                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="active"
                                        {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Activo</option>
                                    <option value="discontinued"
                                        {{ old('status', $product->status) == 'discontinued' ? 'selected' : '' }}>
                                        Descontinuado</option>
                                    <option value="inactive"
                                        {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactivo
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="purchase_price">Precio de Compra (Referencial)</label>
                                <input type="number" name="purchase_price" id="purchase_price"
                                    class="form-control @error('purchase_price') is-invalid @enderror"
                                    value="{{ old('purchase_price', $product->purchase_price) }}" step="0.01">
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="sale_price">Precio de Venta</label>
                                <input type="number" name="sale_price" id="sale_price"
                                    class="form-control @error('sale_price') is-invalid @enderror"
                                    value="{{ old('sale_price', $product->sale_price) }}" step="0.01" required>
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="minimum_stock">Stock Mínimo</label>
                                <input type="number" name="minimum_stock" id="minimum_stock"
                                    class="form-control @error('minimum_stock') is-invalid @enderror"
                                    value="{{ old('minimum_stock', $product->minimum_stock) }}" required>
                                @error('minimum_stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock Actual (No editable aquí)</label>
                            <input type="text" class="form-control" value="{{ $product->stock }}" disabled>
                            <small class="form-text text-muted">El stock solo se modifica mediante Entradas y
                                Salidas.</small>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Volver</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar
                                Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
