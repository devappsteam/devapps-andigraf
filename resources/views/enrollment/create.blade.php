@extends('layouts.default')

@section('content')
    <div class="da-page container py-5">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h3 class="da-page__title">Adicionar Inscrição</h3>
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
                    <form action="{{ route('enrollment.store') }}" method="post" class="w-100" id="form_enrollment">
                        @csrf
                        @method('post')
                        @include('enrollment.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
