@extends('layouts.default')

@section('content')
    <div class="da-page container py-5">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h3 class="da-page__title">Editar Associado</h3>
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
                    <form action="{{ route('associate.update', $associate->uuid) }}" method="post" class="w-100">
                        @csrf
                        @method('put')
                        @include('associate.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
