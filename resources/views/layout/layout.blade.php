<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>@yield('title-page')</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset("assets/img/favicon.png") }}">
        
        <!-- CSS
        ============================================ -->
    
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <!-- Icon Font CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}">
        <!-- Plugins CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
        <!-- Main Style CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

        @yield('add-css')
        <!-- Modernizer JS -->
        <script src="{{ asset('assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    </head>

    <body>
        @yield('content')

        <!-- JS
        ============================================ -->

        <!-- jQuery JS -->
        <script src="{{ asset('assets/js/vendor/jquery-v3.4.1.min.js') }}"></script>
        <!-- Popper JS -->
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <!-- Plugins JS -->
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <!-- Main JS -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

        @yield('add-js')

    </body>

</html>