@extends('layouts.default')

@section('content')
    <div class="da-page container py-5">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h3 class="da-page__title">Editar Inscrição</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-1">
                @include('layouts.partials.alerts')
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-9 mt-4">
                <div class="da-box">
                    <form action="{{ route('enrollment.update', $enrollment->uuid) }}" method="post" class="w-100" id="form_enrollment">
                        @csrf
                        @method('put')
                        @include('enrollment.form')
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-3 mt-4">
                <h3>Notas da inscrição</h3>
                <div style="max-height: 490px; overflow: auto;">
                @if ($enrollment)
                    @forelse ($enrollment->notes as $note)
                        <div class="da-box da-box--column mb-1 p-2">
                            <small>{{ $note->note }}</small>
                            <small>{{ date("d/m/Y H:i:s", strtotime($note->created_at)) }}</small>
                        </div>
                    @empty
                        <p>Nenhuma nota adicionada.</p>
                    @endforelse
                @endif
                </div>
                <p class="font-weight-bold mt-4">
                    Sua inscrição está salva no nosso sistema, porém, para efetivar sua inscrição de forma definitiva clique em "Salvar e Finalizar" até <span class="text-danger">{{ date('d/m/Y', strtotime($enrollment->award->end)) }}</span>.
                </p>
            </div>
        </div>
    </div>
@endsection
