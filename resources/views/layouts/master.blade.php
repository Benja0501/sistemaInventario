@include('partials.header')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i> Blank Page</h1>
            <p>Start a beautiful journey here</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Blank Page</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    Create a beautiful dashboard
                    @includeWhen(session('success'), 'partials.alert-success')
                    @includeWhen(session('error'), 'partials.alert-error')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</main>
@include('partials.footer')
