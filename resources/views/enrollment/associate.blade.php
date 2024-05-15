@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between py-4 bg-white shadow-sm mt-5 mb-3 rounded">
                <div>
                    <h3>Criar inscrição - <b>{{ $enrollment->award->name }}</b></h3>
                    <div class="d-flex align-items-center">
                        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="m-0">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7 16C7 15.8022 7.05865 15.6089 7.16853 15.4444C7.27841 15.28 7.43459 15.1518 7.61732 15.0761C7.80004 15.0004 8.00111 14.9806 8.19509 15.0192C8.38907 15.0578 8.56725 15.153 8.70711 15.2929C8.84696 15.4327 8.9422 15.6109 8.98079 15.8049C9.01937 15.9989 8.99957 16.2 8.92388 16.3827C8.84819 16.5654 8.72002 16.7216 8.55557 16.8315C8.39112 16.9414 8.19778 17 8 17C7.73478 17 7.48043 16.8946 7.29289 16.7071C7.10536 16.5196 7 16.2652 7 16ZM12 15H16C16.2652 15 16.5196 15.1054 16.7071 15.2929C16.8946 15.4804 17 15.7348 17 16C17 16.2652 16.8946 16.5196 16.7071 16.7071C16.5196 16.8946 16.2652 17 16 17H12C11.7348 17 11.4804 16.8946 11.2929 16.7071C11.1054 16.5196 11 16.2652 11 16C11 15.7348 11.1054 15.4804 11.2929 15.2929C11.4804 15.1054 11.7348 15 12 15ZM18 20H6C5.73478 20 5.48043 19.8946 5.29289 19.7071C5.10536 19.5196 5 19.2652 5 19V13H19V19C19 19.2652 18.8946 19.5196 18.7071 19.7071C18.5196 19.8946 18.2652 20 18 20ZM6 6H7V7C7 7.26522 7.10536 7.51957 7.29289 7.70711C7.48043 7.89464 7.73478 8 8 8C8.26522 8 8.51957 7.89464 8.70711 7.70711C8.89464 7.51957 9 7.26522 9 7V6H15V7C15 7.26522 15.1054 7.51957 15.2929 7.70711C15.4804 7.89464 15.7348 8 16 8C16.2652 8 16.5196 7.89464 16.7071 7.70711C16.8946 7.51957 17 7.26522 17 7V6H18C18.2652 6 18.5196 6.10536 18.7071 6.29289C18.8946 6.48043 19 6.73478 19 7V11H5V7C5 6.73478 5.10536 6.48043 5.29289 6.29289C5.48043 6.10536 5.73478 6 6 6ZM18 4H17V3C17 2.73478 16.8946 2.48043 16.7071 2.29289C16.5196 2.10536 16.2652 2 16 2C15.7348 2 15.4804 2.10536 15.2929 2.29289C15.1054 2.48043 15 2.73478 15 3V4H9V3C9 2.73478 8.89464 2.48043 8.70711 2.29289C8.51957 2.10536 8.26522 2 8 2C7.73478 2 7.48043 2.10536 7.29289 2.29289C7.10536 2.48043 7 2.73478 7 3V4H6C5.20435 4 4.44129 4.31607 3.87868 4.87868C3.31607 5.44129 3 6.20435 3 7L3 19C3 19.7956 3.31607 20.5587 3.87868 21.1213C4.44129 21.6839 5.20435 22 6 22H18C18.7956 22 19.5587 21.6839 20.1213 21.1213C20.6839 20.5587 21 19.7956 21 19V7C21 6.20435 20.6839 5.44129 20.1213 4.87868C19.5587 4.31607 18.7956 4 18 4Z"></path>
                        </svg>
                        <span class="ml-1">{{ date('d/m/Y', strtotime($enrollment->award->start)) }} até {{ date('d/m/Y', strtotime($enrollment->award->end)) }}</span>
                    </div>
                </div>
                <div>
                    @if (!$enrollment->products->isEmpty())
                        <button type="button" class="btn btn-danger font-weight-bold conclude_btn" data-toggle="tooltip" title="Sua inscrição será concluída e você será redirecionado para a página de pagamento.">Finalizar e Pagar</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-4 my-2 bg-white shadow-sm rounded">
                <h5 class="font-weight-bold">Produtos Inscritos</h5>
                <div class="d-flex align-items-center justify-content-center flex-column py-4">
                    <p class="font-weight-bold text-center">Quer participar?<br>Clique no botão abaixo e preencha as informações sobre o seu produto para inscrevê-lo.</p>
                    <button class="btn btn-outline-success font-weight-bold" data-toggle="modal" data-target="#modal_product">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="20" height="20">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Inscrever Produto</span>
                    </button>
                </div>
                @include('layouts.partials.alerts')
                <div class="table-responsive my-4">
                    @if (!$enrollment->products->isEmpty())
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produto</th>
                                    <th>Cliente</th>
                                    <th>Data de Conclusão</th>
                                    <th>Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrollment->products as $prod)
                                    <tr id="item_{{ $prod->uuid }}">
                                        <td><b>{{ str_pad($prod->id, 8, 0, STR_PAD_LEFT) }}</b></td>
                                        <td class="text-truncate">{{ $prod->name }}</td>
                                        <td class="text-truncate">{{ $prod->client }}</td>
                                        <td>{{ date('d/m/Y', strtotime($prod->conclude)) }}</td>
                                        <td>
                                            <a href="{{ route('product.edit', ['uuid' => $prod->uuid]) }}"
                                                class="btn btn-sm btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                                    </path>
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm delete"
                                                data-delete="{{ $prod->uuid }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                    <path
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="text-center">
                    <a href="{{ route('enrollment.index') }}" class="btn btn-secondary">Voltar</a>
                    @if (!$enrollment->products->isEmpty())
                        <button type="button" class="btn btn-danger font-weight-bold conclude_btn" data-toggle="tooltip" title="Sua inscrição será concluída e você será redirecionado para a página de pagamento.">Finalizar e Pagar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form id="form_delete" method="post" action="{{ route('product.delete') }}">
        @csrf
        @method('delete')
        <input type="hidden" name="product" id="product_delete" value="">
    </form>

    <form id="form_checkout" method="post" action="{{ route('enrollment.update', ['uuid' => $enrollment->uuid])}}">
        @csrf
        @method('put')
        <input type="hidden" name="status" value="pending">
        <input type="hidden" name="checkout" value="1">
        <input type="hidden" name="note" value="{{ Auth::user()->name }} concluiu a inscrição.">
    </form>

    <!-- Modal -->
    <div class="modal fade" id="modal_product" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('enrollment.product.store') }}" method="post" class="w-100" id="form_product">
                        @csrf
                        @method('post')
                        <input type="hidden" name="award" value="{{ $enrollment->award->id }}">
                        <input type="hidden" name="associate" value="{{ Auth::user()->associate_id }}">
                        <input type="hidden" name="enrollment" value="{{ $enrollment->id }}">

                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="name" class="form-label da-required">Nome do produto</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-4 form-group">
                                <label for="category" class="form-label da-required">Categoria</label>
                                <select name="category" class="form-control" id="category" required>
                                    <option value="" selected>Selecione...</option>
                                    @if (isset($categories))
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="client" class="form-label da-required">Nome do Cliente</label>
                                <input type="text" name="client" class="form-control" id="client" required>
                            </div>
                            <div class="col-12 col-md-4 form-group">
                                <label for="conclude" class="form-label da-required">Data de Conclusão</label>
                                <input type="date" name="conclude" class="form-control" id="conclude" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="print_process" class="form-label da-required">Processo de Impressão</label>
                                <div class="w-100">
                                    @if (isset($print_processes))
                                        @foreach ($print_processes as $print_process)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="print_process[]"
                                                    id="print_process_{{ $print_process->id }}"
                                                    value="{{ $print_process->id }}">
                                                <label class="form-check-label"
                                                    for="print_process_{{ $print_process->id }}">{{ $print_process->name }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="special_features" class="form-label da-required">Recursos Especiais</label>
                                <textarea name="special_features" class="form-control" id="special_features" rows="5" required></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="substrate" class="form-label da-required">Substrato</label>
                                <textarea name="substrate" class="form-control" id="substrate" rows="5" required></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 form-group">
                                <label for="note" class="form-label">Observações</label>
                                <textarea name="note" class="form-control" id="note" rows="5"></textarea>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" form="form_product" class="btn btn-primary">Salvar e Adicionar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function($) {
            $(function() {
                $('.delete').on('click', function(e) {
                    e.preventDefault();
                    const button = $(this);
                    Swal.fire({
                        icon: 'question',
                        title: 'Tem certeza de que deseja excluir este item?',
                        showCancelButton: true,
                        confirmButtonText: 'Sim',
                        cancelButtonText: `Não`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#form_delete').find('#product_delete').val(button.data(
                                'delete'));
                            $('#form_delete').submit();
                        }
                    })
                });

                $('.conclude_btn').on('click', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        icon: 'question',
                        title: 'Tem certeza de que deseja concluir sua inscrição e fazer o pagamento?',
                        showCancelButton: true,
                        confirmButtonText: 'Sim',
                        cancelButtonText: `Não`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#form_checkout').submit();
                        }
                    })
                });
            });
        })(jQuery);
    </script>
@endpush
