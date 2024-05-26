@php
    $sideBarMenus = \App\Models\Menu::active()->orderBy('order')->orderBy('sub_order')->get()->groupBy('order');
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | @yield('page_title')</title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="{{ config('app.name') }} | @yield('page_title')" />
    <meta name="description" content="{{ config('app.app_desc') }}" />
    <meta name="keywords" content="{{ config('app.app_kw') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ config('app.url') }}" />
    <meta property="og:title" content="{{ config('app.name') }} | @yield('page_title')" />
    <meta property="og:description" content="{{ config('app.app_desc') }}" />
    <meta property="og:image" content="{{ asset('assets/images/WebMan_512.png') }}" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{ config('app.url') }}" />
    <meta property="twitter:title" content="{{ config('app.name') }} | @yield('page_title')" />
    <meta property="twitter:description" content="{{ config('app.app_desc') }}" />
    <meta property="twitter:image" content="{{ asset('assets/images/WebMan_512.png') }}" />
    <!-- Meta Tags Generated with https://metatags.io -->

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!-- Google Font - Lato -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <!-- Offline JS -->
    <link rel="stylesheet" href="{{ asset('assets/styles/offline-language-english.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/offline-theme-default.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/styles/main.css') }}">

    @yield('page_styles')
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    @yield('page_modals')
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('assets/images/WebMan_128.png') }}"
                alt="{{ config('app.name') }} Logo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- TODO: Notifications Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary" href="#" role="button" onclick="onThemeSwitchClick(event);">
                        <i class="fas fa-sun" id="themeSwitchIcon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="#" role="button" onclick="onLogoutClick(event);">
                        <i class="fas fa-power-off"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <form id="logoutForm" action="{{ route('logout') }}" method="post" class="d-none">
            @csrf
            <button type="submit">Logout</button>
        </form>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('assets/images/WebMan_128.png') }}" alt="{{ config('app.name') }} Logo"
                    class="brand-image img-circle elevation-3 mr-2" style="opacity: .8">
                <span class="brand-text font-weight-bold h6">{{ config('app.name') }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (auth()->user()->gender === 'Male')
                            <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/images/default/user_image_male.jpg') }}"
                                class="img-circle elevation-2" alt="{{ auth()->user()->name }}">
                        @else
                            <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('assets/images/default/user_image_female.jpg') }}"
                                class="img-circle elevation-2" alt="{{ auth()->user()->name }}">
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        @foreach ($sideBarMenus as $sideBarMenu)
                            @if ($sideBarMenu->count() > 1)
                                @php
                                    $currentMenuRoutes = collect([]);
                                    $currentMenuPermissions = collect([]);
                                    $sideBarMenu->each(function ($el) use (
                                        $currentMenuRoutes,
                                        $currentMenuPermissions,
                                    ) {
                                        $currentMenuRoutes->push($el->route);
                                        $currentMenuPermissions->push(Str::of($el->permissions)->split('/[\s,]+/'));
                                    });
                                    $currentMenuPermissions = $currentMenuPermissions->collapse(
                                        $currentMenuPermissions,
                                    );
                                @endphp
                                <li class="nav-item @if ($currentMenuRoutes->contains(Route::currentRouteName())) menu-open @endif">
                                    <a href="#"
                                        class="nav-link @if ($currentMenuRoutes->contains(Route::currentRouteName())) active @endif">
                                        <i class="nav-icon {{ $sideBarMenu[0]->icon }}"></i>
                                        <p>
                                            {{ $sideBarMenu[0]->title }}
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach ($sideBarMenu as $sm)
                                            @can($sm->permissions ? Str::of($sm->permissions)->split('/[\s,]+/') : [])
                                                <li class="nav-item">
                                                    <a href="{{ route($sm->route) }}"
                                                        class="nav-link @if (Route::currentRouteName() === $sm->route) active @endif">
                                                        <i class="nav-icon {{ $sm->sub_icon }}"></i>
                                                        <p>{{ $sm->sub_title }}</p>
                                                    </a>
                                                </li>
                                            @endcan
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                @can($sideBarMenu[0]->permissions ?
                                    Str::of($sideBarMenu[0]->permissions)->split('/[\s,]+/') : [])
                                    <li class="nav-item">
                                        <a href="{{ route($sideBarMenu[0]->route) }}"
                                            class="nav-link @if (Route::currentRouteName() === $sideBarMenu[0]->route) active @endif">
                                            <i class="nav-icon {{ $sideBarMenu[0]->icon }}"></i>
                                            <p>
                                                {{ $sideBarMenu[0]->title }}
                                            </p>
                                        </a>
                                    </li>
                                @endcan
                            @endif
                        @endforeach
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h1 class="m-0">@yield('page_title')</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->

                    <!-- /.row -->
                    @yield('page_content')
                </div><!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ now()->format('Y') }} <a
                    href="{{ config('app.app_dev_url') }}">{{ config('app.app_dev_name') }}</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> {{ config('app.app_version') }}
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>

    <!-- Offline JS -->
    <script src="{{ asset('assets/scripts/offline.min.js') }}"></script>

    <!-- Axios JS -->
    <script src="{{ asset('assets/scripts/axios.min.js') }}"></script>

    <!-- Dashboard Helper -->
    <script src="{{ asset('assets/scripts/dashboard_helper.js') }}"></script>

    @yield('page_scripts')
</body>

</html>
