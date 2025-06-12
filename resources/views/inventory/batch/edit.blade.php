@extends('layouts.master')

@section('title', 'Editar Lote')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-layer-group"></i> Editar Lote #{{ $batch->id }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('batches.update', $batch) }}" method="POST">
                @csrf @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="product_id">Producto</label>
                        <select name="product_id" class="form-control">
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}" {{ $batch->product_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="batch_number">Número de Lote</label>
                        <input type="text" name="batch_number" class="form-control"
                            value="{{ old('batch_number', $batch->batch_number) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="expiration_date">Fecha de Vencimiento</label>
                        <input type="date" name="expiration_date" class="form-control"
                            value="{{ old('expiration_date', $batch->expiration_date?->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="quantity">Cantidad</label>
                        <input type="number" name="quantity" min="0" class="form-control"
                            value="{{ old('quantity', $batch->quantity) }}">
                    </div>
                </div>

                <button class="btn btn-info"><i class="fas fa-save"></i> Actualizar</button>
                <a href="{{ route('batches.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </form>
        </div>
    </div>
@endsection
