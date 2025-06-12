@extends('layouts.master')

@section('title', 'Lotes')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-layer-group"></i> Lotes</h3>
            <a href="{{ route('batches.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle"></i> Nuevo Lote
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="batches-table" class="table table-striped table-bordered w-100 mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Número de Lote</th>
                            <th>Vencimiento</th>
                            <th>Cantidad</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($batches as $batch)
                            <tr>
                                <td>{{ $batch->id }}</td>
                                <td>{{ $batch->product->name }}</td>
                                <td>{{ $batch->batch_number }}</td>
                                <td>{{ $batch->expiration_date?->format('d/m/Y') ?? '—' }}</td>
                                <td>{{ $batch->quantity }}</td>
                                <td class="text-center">
                                    <a href="{{ route('batches.show', $batch) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('batches.edit', $batch) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('batches.destroy', $batch) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger btn-delete-batch">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No hay lotes registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">{{ $batches->links() }}</div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/batch.js') }}"></script>
@endsection
