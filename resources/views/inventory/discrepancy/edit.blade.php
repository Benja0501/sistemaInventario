@extends('layouts.master')

@section('title', 'Editar Discrepancia')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-exclamation-triangle"></i> Editar #{{ $discrepancy->id }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('discrepancies.update', $discrepancy) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                {{-- mismo bloque de create, pero con valores antiguos --}}
                <!-- Producto y Cantidad Sistema fija -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Producto</label>
                        <input type="text" class="form-control" value="{{ $discrepancy->product->name }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label>Cant. Sistema</label>
                        <input type="number" class="form-control" value="{{ $discrepancy->system_quantity }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="physical_quantity">Cant. Física</label>
                        <input type="number" name="physical_quantity" id="physical_quantity" class="form-control"
                            value="{{ old('physical_quantity', $discrepancy->physical_quantity) }}" min="0" required>
                    </div>
                </div>

                <!-- Tipo, Nota, Evidencia -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="discrepancy_type">Tipo</label>
                        <select name="discrepancy_type" id="discrepancy_type" class="form-control">
                            @foreach ([
            'missing' => 'Faltante',
            'surplus' => 'Sobrante',
            'damaged' => 'Dañado',
            'wrong_location' => 'Ub. Errónea',
            'other' => 'Otro',
        ] as $k => $lbl)
                                <option value="{{ $k }}" {{ $discrepancy->discrepancy_type === $k ? 'selected' : '' }}>
                                    {{ $lbl }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="note">Nota</label>
                        <textarea name="note" id="note" rows="2" class="form-control">{{ old('note', $discrepancy->note) }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="evidence_path">Evidencia actual</label><br>
                        @if ($discrepancy->evidence_path)
                            <a href="{{ asset('storage/' . $discrepancy->evidence_path) }}" target="_blank">Ver archivo</a>
                        @endif
                        <input type="file" name="evidence_path" class="form-control-file mt-1">
                    </div>
                </div>

                <!-- Reportado por y Estado -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="reported_by_user_id">Reportado Por</label>
                        <select name="reported_by_user_id" class="form-control">
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}"
                                    {{ $discrepancy->reported_by_user_id == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="status">Estado</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ $discrepancy->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="resolved" {{ $discrepancy->status === 'resolved' ? 'selected' : '' }}>Resuelta
                            </option>
                        </select>
                    </div>
                </div>

                <button class="btn btn-info"><i class="fas fa-save"></i> Actualizar</button>
                <a href="{{ route('discrepancies.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i>
                    Volver</a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/discrepancy.js') }}"></script>
@endsection
