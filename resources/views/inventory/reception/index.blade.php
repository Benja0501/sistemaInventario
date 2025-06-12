@extends('layouts.master')

@section('title', 'Recepciones')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-receipt"></i> Recepciones</h3>
            <a href="{{ route('receptions.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle"></i> Nueva Recepción
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="receptions-table" class="table table-striped table-bordered w-100 mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Orden</th>
                            <th>Recibido Por</th>
                            <th>Fecha Recepción</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($receptions as $r)
                            <tr>
                                <td>{{ $r->id }}</td>
                                <td>{{ $r->purchaseOrder->order_number }}</td>
                                <td>{{ $r->receiver->name }}</td>
                                <td>{{ $r->received_at->format('d/m/Y H:i') }}</td>
                                <td>{{ ucfirst($r->status) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('receptions.show', $r) }}" class="btn btn-sm btn-outline-primary"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="{{ route('receptions.edit', $r) }}" class="btn btn-sm btn-outline-warning"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ route('receptions.destroy', $r) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger btn-delete-rec"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No hay recepciones aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">{{ $receptions->links() }}</div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/reception.js') }}"></script>
@endsection
