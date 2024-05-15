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
                                <h2 class="mb-4 text-center font-weight-bold">Redefinir Senha</h2>
                            </div>
                            <form method="post" action="{{ route('password.email') }}" class="da-form" autocomplete="off" role="presentation" enctype="utf-8">
                                @csrf

                                <div class="row">
                                    <div class="col-12 my-1">
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label for="email" class="form-label da-required text-muted">E-mail</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" required autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary w-100">Enviar Link de Redefinição</button>
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
