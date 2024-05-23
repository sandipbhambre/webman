<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | @yield('page_title')</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Primary Meta Tags -->
    <meta name="title" content="{{ config('app.name') }} | @yield('page_title')" />
    <meta name="description" content="{{ config('app.desc') }}" />
    <meta name="keywords" content="{{ config('app.keywords') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ config('app.url') }}" />
    <meta property="og:title" content="{{ config('app.name') }} | @yield('page_title')" />
    <meta property="og:description" content="{{ config('app.desc') }}" />
    <meta property="og:image" content="{{ asset('assets/images/WebMan_512.png') }}" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{ config('app.url') }}" />
    <meta property="twitter:title" content="{{ config('app.name') }} | @yield('page_title')" />
    <meta property="twitter:description" content="{{ config('app.desc') }}" />
    <meta property="twitter:image" content="{{ asset('assets/images/WebMan_512.png') }}" />
    <!-- Meta Tags Generated with https://metatags.io -->

    <!-- Google Font - Lato -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,400&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/styles/main.css') }}">

    <!-- Offline JS -->
    <link rel="stylesheet" href="{{ asset('assets/styles/offline-language-english.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/offline-theme-default.css') }}">

    @yield('page_styles')
</head>

<body class="hold-transition login-page">

    <!-- /.login-box -->
    @yield('page_content')

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

    <!-- Offline JS -->
    <script src="{{ asset('assets/scripts/offline.min.js') }}"></script>

    @yield('page_scripts')
</body>

</html>
