@extends('layouts.master')

@section('title', 'Editar Proveedor')
@section('subtitle', 'Modificación de datos del proveedor')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editando a: {{ $supplier->name }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Usamos old('campo', $supplier->campo) para rellenar con los datos existentes --}}

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre o Razón Social</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $supplier->name) }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ruc">RUC</label>
                                    <input type="text" name="ruc" id="ruc"
                                        class="form-control @error('ruc') is-invalid @enderror"
                                        value="{{ old('ruc', $supplier->ruc) }}" required>
                                    @error('ruc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ========================================================= --}}
                        {{-- CAMPOS QUE FALTABAN --}}
                        {{-- ========================================================= --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $supplier->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $supplier->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $supplier->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- ========================================================= --}}

                        <div class="form-group">
                            <label for="status">Estado</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                                required>
                                <option value="active"
                                    {{ old('status', $supplier->status) == 'active' ? 'selected' : '' }}>Activo</option>
                                <option value="inactive"
                                    {{ old('status', $supplier->status) == 'inactive' ? 'selected' : '' }}>Inactivo
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Volver</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar
                                Proveedor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
