{{-- resources/views/inventory/dashboard.blade.php --}}
@extends('layouts.master')

@section('title', 'Dashboard')
@section('subtitle', 'Resumen de actividad')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="tile">
                <h3 class="tile-title">Órdenes Pendientes</h3>
                <div class="tile-body display-4">{{ $pendingOrders }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tile">
                <h3 class="tile-title">Recepciones Hoy</h3>
                <div class="tile-body display-4">{{ $todayReceptions }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tile">
                <h3 class="tile-title">Discrepancias Abiertas</h3>
                <div class="tile-body display-4">{{ $openDiscrepancies }}</div>
            </div>
        </div>
    </div>
@endsection
