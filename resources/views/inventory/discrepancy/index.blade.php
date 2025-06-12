@extends('layouts.master')

@section('title', 'Discrepancias')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-exclamation-triangle"></i> Discrepancias</h3>
            <a href="{{ route('discrepancies.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle"></i> Nueva
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="discrepancies-table" class="table table-striped table-bordered w-100 mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Sistema</th>
                            <th>Físico</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($discrepancies as $d)
                            <tr>
                                <td>{{ $d->id }}</td>
                                <td>{{ $d->product->name }}</td>
                                <td>{{ $d->system_quantity }}</td>
                                <td>{{ $d->physical_quantity }}</td>
                                <td>{{ ucfirst($d->discrepancy_type) }}</td>
                                <td>
                                    @if ($d->status === 'pending')
                                        <span class="badge badge-warning">Pendiente</span>
                                    @else
                                        <span class="badge badge-success">Resuelta</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('discrepancies.show', $d) }}" class="btn btn-sm btn-outline-primary"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="{{ route('discrepancies.edit', $d) }}" class="btn btn-sm btn-outline-warning"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="{{ route('discrepancies.destroy', $d) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger btn-delete-dis"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">No hay discrepancias registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">{{ $discrepancies->links() }}</div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/discrepancy.js') }}"></script>
@endsection
