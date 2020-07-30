<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>

    <!-- Fonts -->

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- ptp style-->
    <link rel="stylesheet" href="css/ptp.css">
    <!-- App Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
    <link rel="stylesheet" href="css/style.css">
    @yield('head')
</head>
<body>
<x-Header />
<div class="ts-main-content">
    <x-leftbar />
    <div class="content-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
</div>
@yield('script')
</body>
</html>
