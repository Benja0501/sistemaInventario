@extends('layouts.master')

@section('title', 'Editar Usuario')
@section('subtitle', 'Modificación de datos del usuario')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- Usamos el nombre del usuario que estamos editando en el título --}}
                    <h3 class="card-title">Editando a: {{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    {{-- El formulario apunta a la ruta 'update' y pasa el ID del usuario --}}
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nombre Completo</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <p class="text-muted">Dejar los campos de contraseña en blanco para no modificarla.</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Nueva Contraseña</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- ========================================================= --}}
                        {{-- CAMPOS PARA ROL Y ESTADO CON LÓGICA DE SEGURIDAD --}}
                        {{-- ========================================================= --}}
                        <div class="row">
                            {{-- Un usuario no puede cambiarse el rol ni el estado a sí mismo --}}
                            @if (auth()->id() !== $user->id)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Rol del Usuario</label>
                                        <select name="role" id="role"
                                            class="form-control @error('role') is-invalid @enderror" required>
                                            <option value="">-- Seleccione un Rol --</option>
                                            <option value="supervisor"
                                                {{ old('role', $user->role) == 'supervisor' ? 'selected' : '' }}>Supervisor
                                            </option>
                                            <option value="purchasing"
                                                {{ old('role', $user->role) == 'purchasing' ? 'selected' : '' }}>Compras
                                            </option>
                                            <option value="warehouse"
                                                {{ old('role', $user->role) == 'warehouse' ? 'selected' : '' }}>Almacén
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
                                            <option value="active"
                                                {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Activo
                                            </option>
                                            <option value="inactive"
                                                {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactivo
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                {{-- Si el usuario está editando su propio perfil, muestra los campos deshabilitados --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Rol del Usuario</label>
                                        <input type="text" class="form-control" value="{{ ucfirst($user->role) }}"
                                            disabled>
                                        <small class="form-text text-muted">No puedes cambiar tu propio rol.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Estado</label>
                                        <input type="text" class="form-control" value="{{ ucfirst($user->status) }}"
                                            disabled>
                                        <small class="form-text text-muted">No puedes cambiar tu propio estado.</small>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar y Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
