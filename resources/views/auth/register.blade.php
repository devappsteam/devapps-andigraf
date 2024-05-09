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

    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                            <h2 class="mb-4 text-center font-weight-bold">Registrar-se</h2>
                        </div>
                        <form method="post" action="{{ route('register') }}" class="da-form" autocomplete="off" role="presentation" enctype="utf-8" x-data="{ showLegal: true }">
                            @csrf
                            <div class="row">
                                    <div class="col-12 my-1">
                                        @include('layouts.partials.alerts')
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="email" class="form-label da-required text-muted w-100">Tipo de
                                        registro</label>
                                    <div class="form-check form-check-inline" @click="showLegal = true">
                                        <input class="form-check-input" type="radio" name="type" id="legal_type"
                                            value="legal" checked>
                                        <label class="form-check-label" for="legal_type">Pessoa Juridica</label>
                                    </div>
                                    <div class="form-check form-check-inline" @click="showLegal = false">
                                        <input class="form-check-input" type="radio" name="type" id="physical_type"
                                            value="physical">
                                        <label class="form-check-label" for="physical_type">Pessoa Fisica</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="document" class="form-label da-required text-muted">CNPJ|CPF</label>
                                    <input name="document" class="form-control" x-mask:dynamic="!showLegal ? '999.999.999-99' : '99.999.999/9999-99'" required>
                                </div>
                            </div>

                            <div class="row" x-show="showLegal">
                                <div class="col-12 form-group">
                                    <label for="company_name" class="form-label da-required text-muted">Razão
                                        Social</label>
                                    <input type="text" name="company_name" class="form-control" autocomplete="off" x-bind:required="showLegal">
                                </div>
                                <div class="col-12 form-group">
                                    <label for="responsible_name" class="form-label da-required text-muted">Responsável</label>
                                    <input type="text" name="responsible_name" class="form-control" autocomplete="off" x-bind:required="showLegal">
                                </div>
                            </div>

                            <div class="row" style="display:none;" x-show="!showLegal">
                                <div class="col-12 form-group">
                                    <label for="first_name" class="form-label da-required text-muted">Nome</label>
                                    <input type="text" name="first_name" class="form-control" autocomplete="off" x-bind:required="!showLegal">
                                </div>
                                <div class="col-12 form-group">
                                    <label for="last_name" class="form-label da-required text-muted">Sobrenome</label>
                                    <input type="text" name="last_name" class="form-control" autocomplete="off" x-bind:required="!showLegal">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="email" class="form-label da-required text-muted">E-mail</label>
                                    <input type="email" name="email" class="form-control" autocomplete="off"
                                        required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="password" class="form-label da-required text-muted">Senha</label>
                                    <input type="password" name="password" class="form-control" autocomplete="off"
                                        minlength="6" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 form-group">
                                    <label for="password_confirmation"
                                        class="form-label da-required text-muted">Confirmar Senha</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        autocomplete="off" minlength="6" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary w-100">Salvar</button>
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
