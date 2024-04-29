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
    </head>
    <body class="da-login">
        <div class="da-wrapper">
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col-12 col-md-7 d-flex flex-column justify-content-center">
                        <div class="da-logo">
                            <img src="{{ asset('assets/images/logo-white.png') }}" alt="Logo" class="img-fluid">
                        </div>
                        <div class="da-description">
                            <p class="m-0 text-white">Trabalhando para fortalecer seu negócio</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 d-flex flex-column justify-content-center">
                        <div class="da-box da-box--column rounded bg-white p-5 w-100 shadow">
                            <div class="da-title">
                                <h2 class="mb-4 text-center font-weight-bold">Entrar</h2>
                            </div>
                            <form method="post" action="{{ route('login') }}" class="da-form" autocomplete="off" role="presentation" enctype="utf-8">
                                @csrf

                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label for="email" class="form-label da-required text-muted">E-mail</label>
                                        <input type="email" name="email" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label for="password" class="form-label da-required text-muted">Senha</label>
                                        <input type="password" name="password" class="form-control" autocomplete="off" minlength="6" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 form-group text-right">
                                        <a href="#" class="text-link">Esqueceu a senha?</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                                    </div>
                                    <div class="col-12 text-center">
                                        <a href="{{ route('associate.public.index') }}" class="btn btn-success fon w-100 mt-3">Associar-se</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
