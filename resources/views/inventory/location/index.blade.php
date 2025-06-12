@extends('layouts.master')

@section('title', 'Ubicaciones')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-map-marker-alt"></i> Ubicaciones</h3>
            <a href="{{ route('locations.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-circle"></i> Nueva Ubicación
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="locations-table" class="table table-striped table-hover table-bordered w-100 mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($locations as $location)
                            <tr>
                                <td>{{ $location->id }}</td>
                                <td>{{ $location->name }}</td>
                                <td>{{ Str::limit($location->description, 50) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('locations.show', $location) }}" class="btn btn-sm btn-outline-primary"
                                        title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('locations.edit', $location) }}" class="btn btn-sm btn-outline-warning"
                                        title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('locations.destroy', $location) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger btn-delete-location" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">No hay ubicaciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $locations->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/location.js') }}"></script>
@endsection
