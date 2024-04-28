@extends('layouts.default')

@section('content')
    <div class="da-page container py-5">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h3 class="da-page__title">Inscrições</h3>
                
                <a href="{{ route('enrollment.print', $enrollment->uuid) }}" target="_blank" class="btn btn-primary">Imprimir</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <div class="da-box da-box--column p-5">
                    <div class="d-flex justify-content-between pb-4 pb-md-5 mb-4 mb-md-5">
                        <img class="image-md" src="{{ asset('assets/images/main-logo.png') }}" width="150" height="50"  alt="{{ config('app.name') }}">
                    </div>
                    <div class="mb-6 d-flex align-items-center justify-content-center">
                        <h2 class="h1 mb-0">Inscrição #{{ str_pad($enrollment->id, 5, "0", STR_PAD_LEFT) }}</h2>
                        @switch($enrollment->status)
                            @case('pending')
                            @default
                                <span class="badge badge-lg badge-primary ml-4">Pendente</span>
                            @break
                            @case('approve')
                                <span class="badge badge-lg badge-success ml-4">Aprovadp</span>
                            @break
                            @case('on-hold')
                                <span class="badge badge-lg badge-warning ml-4">Aguardando</span>
                            @break
                            @case('cancelled')
                                <span class="badge badge-lg badge-danger ml-4">Cancelado</span>
                            @break
                            @case('refunded')
                                <span class="badge badge-lg badge-danger ml-4">Recusado</span>
                            @break
                            @case('failed')
                                <span class="badge badge-lg badge-danger ml-4">Falhou</span>
                            @break

                        @endswitch
                    </div>
                    <div class="row justify-content-between mb-4 mb-md-5">
                        <div class="col-sm">
                            <h5>Associado:</h5>
                            <div>
                                <ul class="list-group simple-list">
                                    <li class="list-group-item border-0 p-0 font-weight-bold">
                                        @if ($enrollment->associate->type == "legal")
                                            {{ $enrollment->associate->responsible_first_name }}
                                        @else
                                            {{ $enrollment->associate->first_name }}
                                        @endif
                                    </li>
                                    <li class="list-group-item border-0 p-0 font-weight-bold">
                                        @if ($enrollment->associate->type == "legal")
                                            {{ $enrollment->associate->fantasy_name }}
                                        @else
                                            {{ $enrollment->associate->first_name }}
                                        @endif
                                    </li>
                                    <li class="list-group-item border-0 p-0 font-weight-bold">
                                        {{ $enrollment->associate->address . ", " . $enrollment->associate->number . ", ". $enrollment->associate->district . " " . $enrollment->associate->city . "/" . $enrollment->associate->state }}
                                    </li>
                                    <li class="list-group-item border-0 p-0 font-weight-bold">
                                        <a class="fw-bold text-primary" href="#">{{ $enrollment->associate->email }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm col-lg-4">
                            <dl class="row text-sm-right">
                                <dt class="col-6"><strong>Inscrição:</strong></dt>
                                <dd class="col-6">{{ str_pad($enrollment->id, 5, "0", STR_PAD_LEFT) }}</dd>
                                <dt class="col-6"><strong>Cadastrado em:</strong></dt>
                                <dd class="col-6"><small>{{ date("d/m/Y H:i:s", strtotime($enrollment->created_at)) }}</small></dd>
                            </dl>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="bg-light border-top">
                                        <tr>
                                            <th scope="row" class="border-0">#</th>
                                            <th scope="row" class="border-0 text-left">Produto</th>
                                            <th scope="row" class="border-0">Cliente</th>
                                            <th scope="row" class="border-0">Concluido em</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($enrollment->products)
                                            @php
                                                $count = 0;
                                            @endphp
                                            @foreach ($enrollment->products as $product)
                                                @php
                                                    $count++;
                                                @endphp
                                                <tr>
                                                    <th scope="row">{{ $count }}</th>
                                                    <th scope="row" class="text-left fw-bold h6">{{ $product->name }}</th>
                                                    <td>{{ $product->client }}</td>
                                                    <td>{{ date("d/m/Y", strtotime($product->conclude)) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end text-right mb-4 py-4">
                                <div class="mt-4">
                                    <table class="table table-clear">
                                        <tbody>
                                            <tr>
                                                <td class="left"><strong>Subtotal</strong></td>
                                                <td class="right">R$ {{ number_format($enrollment->subtotal, 2, ",", ".") }}</td>
                                            </tr>
                                            <tr>
                                                <td class="left"><strong>Desconto</strong></td>
                                                <td class="right">R$ {{ number_format($enrollment->discount, 2, ",", ".") }}</td>
                                            </tr>
                                            <tr>
                                                <td class="left"><strong>Total</strong></td>
                                                <td class="right"><strong>R$ {{ number_format($enrollment->total, 2, ",", ".") }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if($enrollment->status != "approve")
                                <h4>Link de pagamento:</h4><a href="https://pagseguro.uol.com.br/v2/checkout/payment.html?code={{ $enrollment->transaction }}" target="_blank">https://pagseguro.uol.com.br/v2/checkout/payment.html?code={{ $enrollment->transaction }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
