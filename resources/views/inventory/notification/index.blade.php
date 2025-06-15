@extends('layouts.master')

@section('title', 'Centro de Notificaciones')
@section('subtitle', 'Alertas del sistema y mensajes')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Mis Notificaciones</h3>
            @if (auth()->user()->role == 'supervisor')
                <a href="{{ route('notifications.create-manual') }}" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Enviar Alerta Manual
                </a>
            @endif
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @forelse ($notifications as $notification)
                    <li
                        class="list-group-item d-flex justify-content-between align-items-center {{ $notification->read_at ? '' : 'bg-light' }}">
                        <div>
                            {{-- Usamos el tipo de notificación para mostrar un icono diferente --}}
                            @if (Str::contains($notification->type, 'ProductLowStock'))
                                <i class="fas fa-exclamation-triangle text-warning mr-2"></i>
                            @else
                                <i class="fas fa-info-circle text-info mr-2"></i>
                            @endif

                            {{-- Mostramos el mensaje guardado en la columna 'data' --}}
                            <a href="{{ $notification->data['url'] ?? '#' }}"
                                class="text-dark">{{ $notification->data['message'] }}</a>
                            <small class="d-block text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        @if (!$notification->read_at)
                            <span class="badge badge-primary badge-pill">Nueva</span>
                        @endif
                    </li>
                @empty
                    <li class="list-group-item text-center">No tienes notificaciones.</li>
                @endforelse
            </ul>
        </div>
        @if ($notifications->hasPages())
            <div class="card-footer">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
