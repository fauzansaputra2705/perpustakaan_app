<!DOCTYPE html>
<html lang="en">
<head>
    <!--  Title -->
    <title>Login SIAAP</title>
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
    <link id="themeColors" rel="stylesheet" href="{{ asset('modernize/package/dist/css/style.min.css') }}" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead

    <style>
        @media (max-width:1200px){
            .informasi {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('image/Logo SIAAPP.ico') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('image/Logo SIAAPP.ico') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>

    <!--  Body Wrapper -->
    @inertia


</body>
</html>

