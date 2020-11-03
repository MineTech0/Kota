<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PTP Johtajat</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('js/fileinput.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>

    <!-- Bootstrap datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
    <!-- App Styles -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"> 
    @yield('head')
    @stack('scripts')
</head>
<body>
<x-Header/>
<div class="ts-main-content">
    <x-leftbar/>
    <div class="content-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>
@yield('script')
</body>
</html>
