@extends('layouts.master')

@section('title', 'Editar Categoría')
@section('subtitle', 'Modificación de categoría')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editando: {{ $category->name }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nombre de la Categoría</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Estado</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                                required>
                                <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>
                                    Activo</option>
                                <option value="inactive"
                                    {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Volver</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar
                                Categoría</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
