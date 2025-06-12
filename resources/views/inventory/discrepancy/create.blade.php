@extends('layouts.master')

@section('title', 'Nueva Discrepancia')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-exclamation-triangle"></i> Nueva Discrepancia</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('discrepancies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="product_id">Producto</label>
                        <select name="product_id" id="product_id"
                            class="form-control @error('product_id') is-invalid @enderror" required>
                            <option value="">-- Seleccione --</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}" data-system="{{ $p->current_stock }}">
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="system_quantity">Cant. Sistema</label>
                        <input type="number" id="system_quantity" class="form-control" readonly>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="physical_quantity">Cant. Física</label>
                        <input type="number" name="physical_quantity" id="physical_quantity"
                            class="form-control @error('physical_quantity') is-invalid @enderror"
                            value="{{ old('physical_quantity') }}" min="0" required>
                        @error('physical_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="discrepancy_type">Tipo</label>
                        <select name="discrepancy_type" id="discrepancy_type"
                            class="form-control @error('discrepancy_type') is-invalid @enderror" required>
                            <option value="">-- Seleccione --</option>
                            @foreach ([
            'missing' => 'Faltante',
            'surplus' => 'Sobrante',
            'damaged' => 'Dañado',
            'wrong_location' => 'Ub. Errónea',
            'other' => 'Otro',
        ] as $k => $lbl)
                                <option value="{{ $k }}">{{ $lbl }}</option>
                            @endforeach
                        </select>
                        @error('discrepancy_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-8 mb-3">
                        <label for="note">Nota</label>
                        <textarea name="note" id="note" rows="2" class="form-control @error('note') is-invalid @enderror">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="evidence_path">Evidencia (imagen/pdf)</label>
                        <input type="file" name="evidence_path" id="evidence_path"
                            class="form-control-file @error('evidence_path') is-invalid @enderror">
                        @error('evidence_path')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="reported_by_user_id">Reportado Por</label>
                        <select name="reported_by_user_id" id="reported_by_user_id"
                            class="form-control @error('reported_by_user_id') is-invalid @enderror" required>
                            <option value="">-- Usuario --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                        @error('reported_by_user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
                <a href="{{ route('discrepancies.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                    Volver</a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/discrepancy.js') }}"></script>
@endsection
