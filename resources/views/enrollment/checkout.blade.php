@extends('layouts.default')

@section('content')
    <div class="da-page container py-5" x-data="{ formPIX: false }">
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
            <div class="col-md-6 da-box da-box--column">
                <div class="h3 mb-4">Detalhes da Inscrição</div>
                <div class="h5">Número da Inscrição:
                    <strong>#{{ str_pad($enrollment->id, 8, 0, STR_PAD_LEFT) }}</strong>
                </div>
                <div class="h5">Associado | Inscrito: <strong>
                        @if ($enrollment->associate->type == 'legal')
                            {{ $enrollment->associate->fantasy_name }}
                        @else
                            {{ $enrollment->associate->first_name . ' ' . $enrollment->associate->last_name }}
                        @endif
                    </strong></div>
                <div class="h5">Premiação: <strong>{{ $enrollment->award->name }}</strong></div>
                <div class="h5">Total de produtos inscritos: <strong>{{ $enrollment->products_count }}</strong></div>
                <div class="h5">Total: <strong>R$ {{ number_format($enrollment->total, 2, ',', '.') }}</strong></div>

            </div>
            <div class="col-md-6">
                <div id="statusScreenBrick_container"></div>
                <div class="payment-details" id="paymentBrick_container">
                    <!--<form id="form-checkout">
                                            <h3 class="title">Detalhes de Pagamento</h3>
                                            <div class="row">
                                                <div class="form-group col-sm-6">
                                                    <input id="form-checkout__payerFirstName" name="name" type="text" class="form-control"
                                                        placeholder="Nome"
                                                        value="{{ $enrollment->associate->type == 'legal' ? $enrollment->associate->responsible_first_name : $enrollment->associate->first_name }}"
                                                        required />
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <input id="form-checkout__payerLastName" name="lastName" type="text" class="form-control"
                                                        placeholder="Sobrenome"
                                                        value="{{ $enrollment->associate->type == 'legal' ? $enrollment->associate->responsible_last_name : $enrollment->associate->last_name }}"
                                                        required />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col">
                                                    <input id="form-checkout__cardholderEmail" name="email" type="email"
                                                        class="form-control" placeholder="E-mail" value="{{ $enrollment->associate->email }}" />
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
                                            <h3 class="title">Detalhes do Cartão</h3>
                                            <div class="row">
                                                <div class="form-group col-sm-8">
                                                    <input id="form-checkout__cardholderName" name="cardholderName" type="text"
                                                        class="form-control" />
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div class="input-group expiration-date">
                                                        <div id="form-checkout__expirationDate" class="form-control h-40"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-8">
                                                    <div id="form-checkout__cardNumber" class="form-control h-40"></div>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <div id="form-checkout__securityCode" class="form-control h-40"></div>
                                                </div>
                                                <div id="issuerInput" class="form-group col-sm-12 d-none">
                                                    <select id="form-checkout__issuer" name="issuer" class="form-control"></select>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <select id="form-checkout__installments" name="installments" type="text"
                                                        class="form-control"></select>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <input type="hidden" id="amount" />
                                                    <input type="hidden" id="description" />
                                                    <div id="validation-error-messages">
                                                    </div>
                                                    <br>
                                                    <button id="form-checkout__submit" type="submit"
                                                        class="btn btn-primary btn-block">Efetuar Pagamento</button>
                                                    <br>
                                                    <p id="loading-message" style="display: none;">Carregando, por favor aguarde...</p>
                                                </div>
                                            </div>
                                        </form>-->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const publicKey = "{{ config('payment.mercado_pago.public_key') }}";
        const mercadopago = new MercadoPago(publicKey);
        const bricksBuilder = mercadopago.bricks();

        const renderStatusScreenBrick = async (paymentId) => {
            const settings = {
                initialization: {
                    paymentId: paymentId,
                },

                callbacks: {
                    onReady: () => {},
                    onError: (error) => {
                        console.log(error);
                    },
                },
                customization: {
                    visual: {
                        showExternalReference: true
                    }
                }
            };
            window.statusScreenBrickController = await bricksBuilder.create('statusScreen', 'statusScreenBrick_container', settings);
        };

        const renderPaymentBrick = async () => {
            const settings = {
                initialization: {
                    amount: '{{ $enrollment->total }}',
                    payer: {
                        email: '{{ Auth::user()->email }}',
                        identification: {
                            type: '{{ $enrollment->associate->type == 'legal' ? 'CNPJ' : 'CPF' }}',
                            number: '{{ $enrollment->associate->document }}'
                        },
                        address: {
                            zipCode: '{{ $enrollment->associate->postcode }}',
                            city: '{{ $enrollment->associate->city }}',
                            neighborhood: '{{ $enrollment->associate->district }}',
                            streetName: '{{ $enrollment->associate->address }}',
                            streetNumber: '{{ $enrollment->associate->number }}',
                            complement: '{{ $enrollment->associate->complement }}',
                            federalUnit: '{{ $enrollment->associate->state }}',
                        }
                    },
                },
                locale: 'pt-br',
                customization: {
                    paymentMethods: {
                        ticket: "all",
                        bankTransfer: "all",
                        creditCard: "all",
                        mercadoPago: "all",
                        maxInstallments: 12
                    },
                    visual: {
                        showExternalReference: true
                    }
                },
                callbacks: {
                    onReady: () => {},
                    onSubmit: ({
                        selectedPaymentMethod,
                        formData
                    }) => {
                        formData._token = "{{ csrf_token() }}";
                        formData.description =
                            "Inscrição {{ $enrollment->award->name . ' - #' . str_pad($enrollment->id, 8, 0, STR_PAD_LEFT) }}";
                        // callback chamado ao clicar no botão de submissão dos dados
                        return new Promise((resolve, reject) => {
                            fetch("{{ route('enrollment.payment', ['uuid' => $enrollment->uuid]) }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                    },
                                    body: JSON.stringify(formData),
                                })
                                .then((response) => response.json())
                                .then((response) => {
                                    // receber o resultado do pagamento
                                    resolve();
                                    renderStatusScreenBrick(response.id);
                                    $('#paymentBrick_container').fadeOut();
                                })
                                .catch((error) => {
                                    // lidar com a resposta de erro ao tentar criar o pagamento
                                    reject();
                                });
                        });
                    },
                    onError: (error) => {
                        // callback chamado para todos os casos de erro do Brick
                        console.error(error);
                    },
                },
            };
            window.paymentBrickController = await bricksBuilder.create(
                "payment",
                "paymentBrick_container",
                settings
            );
        };

        @if(empty($enrollment->transaction))
            renderPaymentBrick();
        @else
            renderStatusScreenBrick('{{ $enrollment->transaction }}');
        @endif






        /*
                function loadCardForm() {
                    const payButton = document.getElementById("form-checkout__submit");
                    const validationErrorMessages = document.getElementById('validation-error-messages');

                    const form = {
                        id: "form-checkout",
                        cardholderName: {
                            id: "form-checkout__cardholderName",
                            placeholder: "Nome no Cartão",
                        },
                        cardholderEmail: {
                            id: "form-checkout__cardholderEmail",
                            placeholder: "E-mail",
                        },
                        cardNumber: {
                            id: "form-checkout__cardNumber",
                            placeholder: "Número do Cartão",
                            style: {
                                fontSize: "1rem"
                            },
                        },
                        expirationDate: {
                            id: "form-checkout__expirationDate",
                            placeholder: "MM/YYYY",
                            style: {
                                fontSize: "1rem"
                            },
                        },
                        securityCode: {
                            id: "form-checkout__securityCode",
                            placeholder: "CSC",
                            style: {
                                fontSize: "1rem"
                            },
                        },
                        installments: {
                            id: "form-checkout__installments",
                            placeholder: "Parcelas",
                        },
                        identificationType: {
                            id: "form-checkout__identificationType",
                        },
                        identificationNumber: {
                            id: "form-checkout__identificationNumber",
                            placeholder: "Documento",
                        },
                        issuer: {
                            id: "form-checkout__issuer",
                        },
                    };
                    const cardForm = mercadopago.cardForm({
                        amount: '{{ $enrollment->total }}',
                        iframe: true,
                        form,
                        callbacks: {
                            onFormMounted: error => {
                                if (error)
                                    return console.warn("Form Mounted handling error: ", error);
                                console.log("Form mounted");
                            },
                            onSubmit: event => {
                                event.preventDefault();
                                document.getElementById("loading-message").style.display = "block";

                                const {
                                    paymentMethodId,
                                    issuerId,
                                    cardholderEmail: email,
                                    amount,
                                    token,
                                    installments,
                                    identificationNumber,
                                    identificationType,
                                } = cardForm.getCardFormData();

                                fetch("{{ route('enrollment.payment', ['uuid' => $enrollment->uuid]) }}", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                        },
                                        body: JSON.stringify({
                                            _token: "{{ csrf_token() }}",
                                            token,
                                            issuerId,
                                            paymentMethodId,
                                            transactionAmount: Number(amount),
                                            installments: Number(installments),
                                            description: "Inscrição {{ $enrollment->award->name . ' - #' . str_pad($enrollment->id, 8, 0, STR_PAD_LEFT) }}",
                                            payer: {
                                                email,
                                                identification: {
                                                    type: identificationType,
                                                    number: identificationNumber,
                                                },
                                            },
                                        }),
                                    })
                                    .then(response => {
                                        return response.json();
                                    })
                                    .then(result => {
                                        if (result.hasOwnProperty("error_message")) {
                                            document.getElementById("error-message").textContent = result
                                                .error_message;
                                            document.getElementById("fail-response").style.display = "block";
                                        } else {
                                            switch (result.status) {
                                                case 'pending':
                                                    Swal.fire({
                                                        icon: 'info',
                                                        title: 'Pagamento pendente',
                                                        text: 'O pagamento está pendente de processamento.',
                                                        showCancelButton: false,
                                                    });
                                                    break;
                                                case 'approved':
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: 'Pagamento aprovado com sucesso, inscrição aprovada.',
                                                        showCancelButton: false,
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href =
                                                                "{{ route('enrollment.index') }}";
                                                        }
                                                    });
                                                    break;
                                                case 'inprocess':
                                                case 'inmediation':
                                                    Swal.fire({
                                                        icon: 'warning',
                                                        title: 'Pagamento em espera',
                                                        text: 'O pagamento está em espera.',
                                                        showCancelButton: false,
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href =
                                                                "{{ route('enrollment.index') }}";
                                                        }
                                                    });
                                                    break;
                                                case 'rejected':
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Pagamento rejeitado',
                                                        text: 'O pagamento foi rejeitado.',
                                                        showCancelButton: false,
                                                    });
                                                    break;
                                                case 'cancelled':
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Pagamento cancelado',
                                                        text: 'O pagamento foi cancelado.',
                                                        showCancelButton: false,
                                                    });
                                                    break;
                                                case 'refunded':
                                                case 'chargeback':
                                                    Swal.fire({
                                                        icon: 'info',
                                                        title: 'Pagamento reembolsado',
                                                        text: 'O pagamento foi reembolsado.',
                                                        showCancelButton: false,
                                                    });
                                                    break;
                                                default:
                                                    Swal.fire({
                                                        icon: 'info',
                                                        title: 'Status desconhecido',
                                                        text: 'O status do pagamento não pôde ser determinado.',
                                                        showCancelButton: false,
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href =
                                                                "{{ route('enrollment.index') }}";
                                                        }
                                                    });
                                            }
                                        }
                                    })
                                    .catch(error => {
                                        alert("Unexpected error\n" + JSON.stringify(error));
                                    });
                            },
                            onFetching: (resource) => {
                                console.log("Fetching resource: ", resource);
                                payButton.setAttribute('disabled', true);
                                return () => {
                                    payButton.removeAttribute("disabled");
                                };
                            },
                            onCardTokenReceived: (errorData, token) => {
                                if (errorData && errorData.error.fieldErrors.length !== 0) {
                                    errorData.error.fieldErrors.forEach(errorMessage => {
                                        alert(errorMessage);
                                    });
                                }

                                return token;
                            },
                            onValidityChange: (error, field) => {
                                const input = document.getElementById(form[field].id);
                                removeFieldErrorMessages(input, validationErrorMessages);
                                addFieldErrorMessages(input, validationErrorMessages, error);
                                enableOrDisablePayButton(validationErrorMessages, payButton);
                            }
                        },
                    });
                };

                function removeFieldErrorMessages(input, validationErrorMessages) {
                    Array.from(validationErrorMessages.children).forEach(child => {
                        const shouldRemoveChild = child.id.includes(input.id);
                        if (shouldRemoveChild) {
                            validationErrorMessages.removeChild(child);
                        }
                    });
                }

                function addFieldErrorMessages(input, validationErrorMessages, error) {
                    if (error) {
                        input.classList.add('validation-error');
                        error.forEach((e, index) => {
                            const p = document.createElement('p');
                            p.id = `${input.id}-${index}`;
                            p.innerText = e.message;
                            validationErrorMessages.appendChild(p);
                        });
                    } else {
                        input.classList.remove('validation-error');
                    }
                }

                function enableOrDisablePayButton(validationErrorMessages, payButton) {
                    if (validationErrorMessages.children.length > 0) {
                        payButton.setAttribute('disabled', true);
                    } else {
                        payButton.removeAttribute('disabled');
                    }
                }
        */
        (function($) {
            $(function() {
                //loadPaymentForm();
            });
        })(jQuery);
    </script>
@endpush
