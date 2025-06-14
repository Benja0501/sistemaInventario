@extends('layouts.master')

@section('title', 'Ver Proveedor')
@section('subtitle', 'Detalles del proveedor')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles del Proveedor: {{ $supplier->name }}</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">ID</dt>
                        <dd class="col-sm-9">{{ $supplier->id }}</dd>

                        <dt class="col-sm-3">Nombre / Razón Social</dt>
                        <dd class="col-sm-9">{{ $supplier->name }}</dd>

                        <dt class="col-sm-3">RUC</dt>
                        <dd class="col-sm-9">{{ $supplier->ruc }}</dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">{{ $supplier->email ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Teléfono</dt>
                        <dd class="col-sm-9">{{ $supplier->phone ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Dirección</dt>
                        <dd class="col-sm-9">{{ $supplier->address ?? 'N/A' }}</dd>

                        <dt class="col-sm-3">Estado</dt>
                        <dd class="col-sm-9">
                            @if ($supplier->status == 'active')
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </dd>

                        <dt class="col-sm-3">Registrado el</dt>
                        <dd class="col-sm-9">{{ $supplier->created_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
                <div class="card-footer">
                    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                        Volver</a>
                    <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning"><i class="fas fa-edit"></i>
                        Editar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
