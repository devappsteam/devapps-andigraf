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
    <body class="da-panel {{ $bodyClass ?? "" }}" style="background: #FFF;">

        <!-- begin: Content -->
        <div class="da-page container-fluid">
            <div class="row">
                <div class="col-12 mt-4">
                    @include('layouts.partials.alerts')
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="da-box">
                        <form action="{{ route('associate.public.store') }}" method="post" class="w-100">
                            @csrf
                            @method('post')
                            @include('associate.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end: Content -->

        <!-- Global Scripts -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

        <!-- Custom Scripts -->
        @stack('scripts')
    </body>
</html>
