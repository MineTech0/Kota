<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kota</title>
    <!-- App Styles -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
    @yield('head')
</head>

<body>
    <x-Header />
    <div class="ts-main-content">
        <x-leftbar />
        <div class="content-wrapper">
            <div class="container-fluid">
                <div id="app">
                    <app>
                        @yield('content')
                    </app>
                </div>
            </div>
        </div>
        <div id="modals"></div>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('script')
    @stack('scripts')
</body>

</html>
