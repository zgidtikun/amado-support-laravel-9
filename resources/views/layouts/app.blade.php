<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME'); }} - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app-custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome/css/all.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
</head>
<body class="fixed-nav sticky-footer bg-white">
    <nav class="navbar navbar-expand-lg navbar-amado bg-white fixed-top" id="mainNav">
        <img class="logo-nav" src="{{ asset('images/logo-red.png') }}" alt="">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav scrollbar-custom bg-white" id="menu-nav">
                @include('layouts.menu.mis-admin')
            </ul>
            
            <ul class="navbar-nav ml-auto">
            @if(Auth::user())
                <li class="nav-item my-auto">
                    <span class="text-dark">
                    @if(Auth::user()->username)
                        <i class="fas fa-user text-amado-blue mr-2"></i> {{ Auth::user()->name }}
                    @else
                        No Session was announced.
                    @endif
                    </span>
                    <span class="text-dark ml-2 mx-3">|</span>
                </li>                            
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="ml-2">Logout</span>
                    </a>
                </li>
            @endif
            </ul>
            
        </div>
    </nav>
    <div class="content-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</body>
</html>
