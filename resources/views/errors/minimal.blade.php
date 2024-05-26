<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <!-- Google Font - Lato -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,400&display=swap"
        rel="stylesheet">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/styles/main.css') }}">

    <!-- Offline JS -->
    <link rel="stylesheet" href="{{ asset('assets/styles/offline-language-english.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/offline-theme-default.css') }}">
</head>

<body class="vw-100 vh-100">
    <div class="d-flex justify-content-center align-items-center bg-dark flex-column w-100 h-100">
        <div class="mb-3">
            <a href="{{ route('dashboard') }}" class="h5 font-weight-bold">
                <img src="{{ asset('assets/images/WebMan_128.png') }}" alt="{{ config('app.name') }} Logo"
                    width="32px" height="auto" class="mr-1">
                {{ config('app.name') }}
            </a>
        </div>
        <div>@yield('code') | @yield('message')</div>
        <hr class="border-top border-white w-25">
        <div>@yield('home_link')</div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

    <!-- Offline JS -->
    <script src="{{ asset('assets/scripts/offline.min.js') }}"></script>
</body>

</html>
