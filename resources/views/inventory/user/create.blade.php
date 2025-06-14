@extends('layouts.master')

@section('title', 'Nuevo Usuario')
@section('subtitle', 'Creación de un nuevo usuario para el sistema')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Nuevo Usuario</h3>
                </div>
                <div class="card-body">
                    {{-- El formulario apunta a la ruta para guardar el usuario --}}
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nombre Completo</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Agrupamos los campos de contraseña en una fila --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>

                        {{-- ========================================================= --}}
                        {{-- CAMPOS AÑADIDOS PARA ROL Y ESTADO --}}
                        {{-- ========================================================= --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Rol del Usuario</label>
                                    <select name="role" id="role"
                                        class="form-control @error('role') is-invalid @enderror" required>
                                        <option value="">-- Seleccione un Rol --</option>
                                        <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>
                                            Supervisor</option>
                                        <option value="purchasing" {{ old('role') == 'purchasing' ? 'selected' : '' }}>
                                            Compras</option>
                                        <option value="warehouse" {{ old('role') == 'warehouse' ? 'selected' : '' }}>Almacén
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Estado</label>
                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                            Activo</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactivo</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar y Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
