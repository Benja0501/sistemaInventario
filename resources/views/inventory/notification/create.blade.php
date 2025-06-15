@extends('layouts.master')

@section('title', 'Enviar Alerta Manual')
@section('subtitle', 'Comunicación interna para el equipo')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Enviar Nueva Alerta</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('notifications.store-manual') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="recipient_type">Enviar a:</label>
                    <select name="recipient_type" id="recipient_type" class="form-control" required>
                        <option value="all">Todos los Usuarios</option>
                        <option value="role">Un Rol Específico</option>
                        <option value="user">Un Usuario Específico</option>
                    </select>
                </div>

                <div id="role-selector" class="form-group d-none">
                    <label for="role">Seleccione el Rol</label>
                    <select name="role" id="role" class="form-control">
                        <option value="supervisor">Supervisores</option>
                        <option value="purchasing">Compras</option>
                        <option value="warehouse">Almacén</option>
                    </select>
                </div>

                <div id="user-selector" class="form-group d-none">
                    <label for="user_id">Seleccione el Usuario</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="subject">Asunto</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="message">Mensaje</label>
                    <textarea name="message" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mt-4">
                    <a href="{{ route('notifications.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                        Cancelar</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Enviar Alerta</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Script para mostrar/ocultar los selectores según la opción elegida
        document.getElementById('recipient_type').addEventListener('change', function() {
            const roleSelector = document.getElementById('role-selector');
            const userSelector = document.getElementById('user-selector');

            roleSelector.classList.add('d-none');
            userSelector.classList.add('d-none');

            if (this.value === 'role') {
                roleSelector.classList.remove('d-none');
            } else if (this.value === 'user') {
                userSelector.classList.remove('d-none');
            }
        });
    </script>
@endpush
