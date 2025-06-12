@extends('layouts.master')

@section('title', 'Editar Ubicación')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-map-marker-alt"></i> Editar Ubicación #{{ $location->id }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('locations.update', $location) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $location->name) }}"
                        required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description', $location->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-info"><i class="fas fa-save"></i> Actualizar</button>
                <a href="{{ route('locations.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </form>
        </div>
    </div>
@endsection
