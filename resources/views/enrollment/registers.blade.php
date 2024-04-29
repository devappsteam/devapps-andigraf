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

    <!-- Custom Style -->
</head>

<body class="da-panel" onload="window.print()">

    <div class="da-page container">
        <div class="row">
            <div class="col-12 mt-4">
                <div class="da-box da-box--column p-5">
                    <div class="d-flex justify-content-between pb-4 pb-md-5 mb-4 mb-md-5">
                        <img class="image-md" src="{{ asset('assets/images/main-logo.png') }}" width="150"
                            height="50" alt="{{ config('app.name') }}">
                    </div>
                    <div class="mb-6 d-flex align-items-center justify-content-center mb-5">
                        <h2 class="h1 mb-0">Inscrição #{{ str_pad($enrollment->id, 5, '0', STR_PAD_LEFT) }}</h2>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            @if ($enrollment->products)
                                @foreach ($enrollment->products as $product)
                                    <div class="mb-5">
                                        @foreach ($categories as $category)
                                            @if ($category->id == $product->product_category_id)
                                                @php
                                                    $category_name = $category->name;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            $process = [];
                                        @endphp
                                        @if (isset($print_processes))
                                            @foreach ($print_processes as $print_process)
                                                @foreach ($product->print_processes as $p_process)
                                                    @if ($print_process->id == $p_process->id)
                                                        @php
                                                            $process[] = $print_process->name;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                        <h2>{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }} - {{ $product->name }}</h2>
                                        <h5><b>Cliente:</b> {{ $product->client }}</h5>
                                        <h5><b>Concluido em:</b> {{ date('d/m/Y', strtotime($product->conclude)) }}</h5>
                                        <h5><b>Categoria:</b> {{ $category_name }}</h5>
                                        <h5><b>Processos de Impressão:</b> {{ implode(' | ', $process) }}</h5>
                                        <h5><b>Recursos Especiais:</b></h5>
                                        <h5>{{ $product->special_features }}</h5>
                                        <h5><b>Substrato:</b></h5>
                                        <h5>{{ $product->substrate }}</h5>
                                        <h5><b>Observações:</b></h5>
                                        <h5>{{ $product->note ?? "Não Possui" }}</h5>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
