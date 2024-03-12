<!DOCTYPE html>
<html lang="en">
<head>
    <!--  Title -->
    {{-- <title> SIAAP</title> --}}
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    {{-- <meta name="description" content="Mordenize" /> --}}
    {{-- <meta name="author" content="" /> --}}
    {{-- <meta name="keywords" content="Mordenize" /> --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('image/Logo SIAAPP.ico') }}" />
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="{{ asset('modernize/package/dist/css/style.css') }}" />

    <!-- Scripts -->
    @routes
    @vite([
        'resources/js/app.js',

        //css
        'resources/js/asset/css/dataTables.bootstrap5.min.css',
        'resources/js/asset/css/bootstrap-switch.min.css',

        //js
        'resources/js/asset/js/simplebar.min.js',
        'resources/js/asset/js/app.min.js',
        'resources/js/asset/js/app.init.js',
        'resources/js/asset/js/sidebarmenu.js',
        'resources/js/asset/js/custom.js',

        // "resources/js/Pages/{$page['component']}.vue"
    ])
    @inertiaHead


    <style>
        @media (max-width:1200px){
            .informasi {
                display: none;
            }
        }

        .sidebar-nav ul .sidebar-item.selected>
        .sidebar-link, .sidebar-nav ul .sidebar-item.selected>
        .sidebar-link.active, .sidebar-nav ul .sidebar-item>
        .sidebar-link.active {
            background: var(--primary-gradient, linear-gradient(134deg, #2B4ABE 0%, #2EA95F 100%));
        }

        .sidebar-nav ul .sidebar-item .first-level .sidebar-item .sidebar-link.active {
            background: transparent;
            color: #5d87ff;
        }
    </style>
</head>
<body>

    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('image/Logo SIAAPP.ico') }}" alt="loader"
        class="lds-ripple img-fluid" style="width: 150px;"/>
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('image/Logo SIAAPP.ico') }}" alt="loader"
        class="lds-ripple img-fluid" style="width: 150px;"/>
    </div>

    <!--  Body Wrapper -->
    @inertia

</body>
</html>

