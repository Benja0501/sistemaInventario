<div class="modal fade modalPermisos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="formPermisos" method="POST" action="{{ route('inventory.roles.permissions.save', $role) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Permisos para: {{ $role->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Módulo</th>
                                <th class="text-center">Leer</th>
                                <th class="text-center">Crear</th>
                                <th class="text-center">Actualizar</th>
                                <th class="text-center">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modules as $key => $label)
                                @php
                                    $p = $perms->get($key);
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $label }}</td>
                                    @foreach (['r' => 'r', 'w' => 'w', 'u' => 'u', 'd' => 'd'] as $col => $flag)
                                        <td class="text-center">
                                            <input type="checkbox"
                                                name="permissions[{{ $key }}][{{ $col }}]"
                                                {{ $p && $p->$flag ? 'checked' : '' }}>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle"></i> Guardar
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $('#formPermisos').submit(function(e) {
                e.preventDefault();
                $.post($(this).attr('action'), $(this).serialize(), function(res) {
                    if (res.status) {
                        $('.modalPermisos').modal('hide');
                        alert(res.msg);
                    }
                });
            });
        });
    </script>
@endpush
