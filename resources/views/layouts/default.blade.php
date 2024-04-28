<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'DevApps Consultoria e Desenvolvimento') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Global Style -->
        <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

        <!-- Custom Style -->
        @stack('styles')
    </head>
    <body class="da-panel {{ $bodyClass ?? "" }}">
        <!-- begin: Header -->
        @include('layouts.partials.header')
        <!-- end: Header -->

        <!-- begin: Content -->
        @yield('content')
        <!-- end: Content -->

        <!-- begin: Footer -->
            <p class="text-center text-muted">&copy; Todos os direitos reservados - 2023 | DevApps Consultoria e Desenvolvimento</p>
        <!-- end: Footer -->

        <!-- Global Scripts -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

        <!-- Custom Scripts -->
        @stack('scripts')
    </body>
</html>
