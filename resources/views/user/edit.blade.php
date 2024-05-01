@extends('layouts.default')

@section('content')
    <div class="da-page container py-5">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h3 class="da-page__title">Editar Usuário</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-secondary">
                    Os usuários registrados nesta tela são responsáveis pela administração.
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-1">
                @include('layouts.partials.alerts')
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="da-box">
                    <form action="{{ route('user.update', $user->uuid) }}" method="post" class="w-100">
                        @csrf
                        @method('put')
                        @include('user.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
