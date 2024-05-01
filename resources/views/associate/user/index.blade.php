@extends('layouts.default')

@section('content')
    <div class="da-page container py-5">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h3 class="da-page__title">Associado {{ $associate->type == 'legal' ? $associate->fantasy_name : $associate->first_name }} | Usuário</h3>
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
                    <form action="{{ route('associate.user.update', ['uuid' => $associate->uuid]) }}" method="post" class="w-100">
                        @csrf
                        @method('post')
                        @include('associate.user.form', ['user' => $associate->user])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
