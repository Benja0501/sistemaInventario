{{-- resources/views/layouts/master.blade.php --}}
@include('partials.header') {{-- esto incluye <html>, <head>, <body> y el header + nav --}}

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i> @yield('title', 'Dashboard')</h1>
            <p>@yield('subtitle', '')</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">@yield('title', '')</li>
        </ul>
    </div>

    {{-- Flash messages --}}
    @includeWhen(session('success'), 'partials.alert-succes')
    @includeWhen(session('error'), 'partials.alert-error')

    {{-- Aquí va el contenido de cada vista --}}
    @yield('content')
</main>

@include('partials.footer') {{-- esto cierra </body> y </html> --}}
