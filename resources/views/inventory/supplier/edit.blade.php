@extends('layouts.master')

@section('title', 'Editar Proveedor')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-truck"></i> Editar Proveedor</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="business_name" class="form-label">Razón Social</label>
                    <input type="text" name="business_name" id="business_name"
                        class="form-control @error('business_name') is-invalid @enderror"
                        value="{{ old('business_name', $supplier->business_name) }}" required>
                    @error('business_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tax_id" class="form-label">RUC / NIT</label>
                    <input type="text" name="tax_id" id="tax_id"
                        class="form-control @error('tax_id') is-invalid @enderror"
                        value="{{ old('tax_id', $supplier->tax_id) }}" required>
                    @error('tax_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Dirección</label>
                    <input type="text" name="address" id="address"
                        class="form-control @error('address') is-invalid @enderror"
                        value="{{ old('address', $supplier->address) }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="text" name="phone" id="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $supplier->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $supplier->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Estado</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                        required>
                        <option value="active" {{ old('status', $supplier->status) == 'active' ? 'selected' : '' }}>Activo
                        </option>
                        <option value="inactive" {{ old('status', $supplier->status) == 'inactive' ? 'selected' : '' }}>
                            Inactivo</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-info">
                    <i class="fas fa-save"></i> Actualizar
                </button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
            </form>
        </div>
    </div>
@endsection
