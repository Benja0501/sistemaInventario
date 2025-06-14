@extends('layouts.master')

@section('title', 'Nuevo Producto')
@section('subtitle', 'Registro de nuevo producto')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Nuevo Producto</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label for="name">Nombre del Producto</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="sku">SKU (Código)</label>
                                <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                                    value="{{ old('sku') }}">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="category_id">Categoría</label>
                                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror"
                                    required>
                                    <option value="">-- Seleccione una Categoría --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="status">Estado</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="active" selected>Activo</option>
                                    <option value="discontinued">Descontinuado</option>
                                    <option value="inactive">Inactivo</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="purchase_price">Precio de Compra (Referencial)</label>
                                <input type="number" name="purchase_price"
                                    class="form-control @error('purchase_price') is-invalid @enderror"
                                    value="{{ old('purchase_price') }}" step="0.01">
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="sale_price">Precio de Venta</label>
                                <input type="number" name="sale_price"
                                    class="form-control @error('sale_price') is-invalid @enderror"
                                    value="{{ old('sale_price') }}" step="0.01" required>
                                @error('sale_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="minimum_stock">Stock Mínimo</label>
                                <input type="number" name="minimum_stock"
                                    class="form-control @error('minimum_stock') is-invalid @enderror"
                                    value="{{ old('minimum_stock', 10) }}" required>
                                @error('minimum_stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Volver</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar
                                Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
