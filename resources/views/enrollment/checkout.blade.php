@extends('layouts.default')

@section('content')
    <div class="da-page container py-5">
        <div class="row">
            <div class="col-12 p-0">
                <h3 class="da-page__title">Finalizar Pagamento</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12 my-1">
                @include('layouts.partials.alerts')
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 card p-0">

                <div class="card-header">
                    Detalhes da Inscrição
                </div>
                <div class="card-body">
                    <p>Número da Inscrição: <strong>#{{ str_pad($enrollment->id, 8, 0, STR_PAD_LEFT) }}</strong></p>
                    <p>Premiação: <strong>{{ $enrollment->award->name }}</strong></p>
                    <p>Associado | Inscrito: <strong>
                            @if ($enrollment->associate->type == 'legal')
                                {{ $enrollment->associate->fantasy_name }}
                            @else
                                {{ $enrollment->associate->first_name . ' ' . $enrollment->associate->last_name }}
                            @endif
                        </strong></p>
                    <p>Total de produtos inscritos: <strong>{{ $enrollment->products_count }}</strong></p>
                    <!--<p>Subtotal: <strong>R$ {{ number_format($enrollment->subtotal, 2, ',', '.') }}</strong></p>-->
                    <!--<p>Desconto: <strong>R$ {{ number_format($enrollment->discount, 2, ',', '.') }}</strong></p>-->
                    <p>Total: <strong>R$ {{ number_format($enrollment->total, 2, ',', '.') }}</strong></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="payment-details da-box da-box--column">
                    <form id="form-checkout">
                        <h3 class="title">Detalhes do Comprador</h3>
                        <div class="row">
                            <div class="form-group col">
                                <input id="form-checkout__cardholderEmail" name="cardholderEmail" type="email"
                                    class="form-control" value="{{ $enrollment->associate->email }}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <select id="form-checkout__identificationType" name="identificationType"
                                    class="form-control">
                                    <option value="CPF"
                                        {{ $enrollment->associate->type == 'physical' ? 'selected' : '' }}>CPF</option>
                                    <option value="CNPJ" {{ $enrollment->associate->type == 'legal' ? 'selected' : '' }}>
                                        CNPJ</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-7">
                                <input id="form-checkout__identificationNumber" name="docNumber" type="text"
                                    class="form-control" value="{{ $enrollment->associate->document }}" />
                            </div>
                        </div>
                        <br>
                        @if($enrollment->payment_type == 'credit_card')
                        <h3 class="title">Detalhes do Cartão</h3>
                        <div class="row">
                            <div class="form-group col-12">
                                <input id="form-checkout__cardholderName" name="cardholderName" type="text"
                                    class="form-control" placeholder="Nome exbido no cartão" />
                            </div>
                            <div class="form-group col-md-6">
                                <input id="form-checkout__cardholderName" name="cardholderName" type="text"
                                    class="form-control" placeholder="Número do cartão" />
                            </div>
                            <div class="form-group col-md-3">
                                <input id="form-checkout__cardholderName" name="cardholderName" type="text"
                                    class="form-control" placeholder="MM/YY" />
                            </div>
                            <div class="form-group col-md-3">
                                <input id="form-checkout__cardholderName" name="cardholderName" type="text"
                                    class="form-control" placeholder="CVC" />
                            </div>
                        </div>
                        @endif
                        @if($enrollment->payment_type == 'pix')
                        <div class="alert alert-secondary">
                            O QRCode será exibido após confirmação de pagamento.
                        </div>
                        <div id="qr_pix" style="display: none;">
                            <img src="{{ asset('assets/images/pix.png') }}" class="img-fluid">
                        </div>
                        @endif
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <input type="hidden" id="amount" />
                                <input type="hidden" id="description" />
                                <div id="validation-error-messages"></div>
                                <br>
                                <button id="form-checkout__submit" type="button" class="btn btn-primary btn-block">Efetuar Pagamento</button>
                                <br>
                                <p id="loading-message" style="display: none;">Carregando, por favor aguarde...</p>
                                <br>
                                <a href="{{ route('enrollment.edit', ['uuid' => $enrollment->uuid]) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                        viewBox="0 0 10 10" class="chevron-left">
                                        <path fill="#009EE3" fill-rule="nonzero"id="chevron_left"
                                            d="M7.05 1.4L6.2.552 1.756 4.997l4.449 4.448.849-.848-3.6-3.6z"></path>
                                    </svg>
                                    Trocar meio de pagamento.
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        (function($){
            $(function(){
                $('#form-checkout__submit').on('click', function(e){
                    e.preventDefault();
                    $(this).prop('disabled', true);
                    $('#loading-message').show();
                    setTimeout(() => {
                        $('#qr_pix').show();
                        $('#loading-message').hide();
                    }, 3000);
                    @if($enrollment->payment_type == 'credit_card')
                    setTimeout(() => {
                        Swal.fire({
                            icon: 'info',
                            title: 'Pagamento em processamento. Redirecionando para às inscrições.',
                            showCancelButton: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('enrollment.update_temp', ['uuid' => $enrollment->uuid]) }}";
                            }
                        })
                    }, 3000);
                    @endif
                });
            });
        })(jQuery);
    </script>
@endpush
