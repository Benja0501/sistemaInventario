{{-- resources/views/partials/footer.blade.php --}}

<!-- Essential javascripts for application to work-->
<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/fontawesome.js') }}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{ asset('assets/js/plugins/pace.min.js') }}"></script>
<!-- Page specific javascripts-->
<script type="text/javascript" src="{{ asset('assets/js/plugins/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>

<!-- Data table plugin-->
<script type="text/javascript" src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript"
    src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="{{ asset('assets/js/datepicker/jquery-ui.min.js') }}"></script>
@php
    $routeName = \Route::currentRouteName() ?? '';
    $parts = explode('.', $routeName);
    $viewKey = $parts[0] ?? null;
    // prueba tanto plural como singular:
    $candidates = [];
    if ($viewKey) {
        $candidates[] = $viewKey; // e.g. "users"
        $candidates[] = rtrim($viewKey, 's'); // e.g. "user"
    }
@endphp

@foreach ($candidates as $key)
    @if (is_file(public_path("assets/js/{$key}.js")))
        <script src="{{ asset("assets/js/{$key}.js") }}"></script>
        @break
    @endif
@endforeach

</body>

</html>
