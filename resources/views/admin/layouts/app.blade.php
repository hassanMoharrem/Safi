<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="theme-color" content="#000000"/>
    <title>Safi</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo-white.png') }}">
    @vite(['resources/js/app.js','resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script href="{{ asset('assets/plugin/jquery/jquery-3.7.0.min.js') }}"></script>
</head>
<body>
<header>
    <div class="container">
        <div class="row mx-auto w-100 g-0">
            <div class="col-6 my-2 my-md-auto">
                <img src="{{ asset('assets/images/logo.png') }}" width="36" height="41" alt="Safi">
{{--                <h5 class="font-size-20 d-inline-block ms-1 align-middle mb-0">Manea</h5>--}}
            </div>
        </div>
    </div>
</header>
<main>
    <div class="main d-flex">
        <div class="sidebar width-94">
            <div class="text-center position-relative h-100 pb-2">
                <a href="{{ route('admin.dashboard') }}" class="mt-5 toll d-block"><img src="{{ asset('assets/images/home') }}{{ request()->is('admin') ? '-active.svg' : '.svg' }}" width="21" alt=""></a>
                <a href="{{ route('admin.users.index') }}" class="mt-5 toll d-block"><img src="{{ asset('assets/images/user') }}{{ request()->is('admin/users*') ? '-active.png' : '.png' }}" width="21" alt=""></a>
                <a href="{{ route('admin.logout') }}" class="mt-5 toll d-block"><img src="{{ asset('assets/images/logout.svg') }}" width="20" alt=""></a>

            </div>
        </div>
        <div class="width-calc ps-2 pt-2 pb-5">
            @yield('content')
        </div>
    </div>
</main>
</body>
</html>
