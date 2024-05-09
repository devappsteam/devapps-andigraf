<div class="container-fluid">
    @if (empty(Auth::user()->associate_id))
        <div class="row">
            <div class="col-12 my-2">
                <div class="alert alert-secondary text-center">
                    <strong>Atenção:</strong> Inscrições efetuadas pelo painel administrativo não terão processamento de
                    pagamento.
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12 col-md-6 form-group">
            <label for="award" class="form-label da-required">Premiação</label>
            <select name="award" class="form-control" id="award" required
                {{ !empty(Auth::user()->associate_id) ? 'readonly' : '' }}>
                <option value="">Selecione...</option>
                @if (isset($awards))
                    @foreach ($awards as $award)
                        <option value="{{ $award->id }}"
                            {{ (isset($enrollment) && $enrollment->award_id == $award->id) || Award::active() == $award->id ? 'selected' : '' }}>
                            {{ $award->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-12 col-md-6 form-group">
            <label for="associate" class="form-label da-required">Associado</label>
            <select name="associate" class="form-control" id="associate" required
                {{ !empty(Auth::user()->associate_id) ? 'readonly' : '' }}>
                <option value="">Selecione...</option>
                @if (isset($associates))
                    @foreach ($associates as $associate)
                        <option value="{{ $associate->id }}"
                            {{ (isset($enrollment) && $enrollment->associate_id == $associate->id) || Auth::user()->associate_id == $associate->id ? 'selected' : '' }}>
                            @if ($associate->type == 'legal')
                                {{ $associate->corporate_name }}
                            @else
                                {{ $associate->first_name }}
                            @endif
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 form-group">
            <label for="payment_type" class="form-label da-required">Meio de Pagamento</label>
            <select name="payment_type" class="form-control" id="payment_type" required>
                <option value="">Selecione...</option>
                <option value="credit_card"
                    {{ isset($enrollment) && $enrollment->payment_type == 'credit_card' ? 'selected' : '' }}>Cartão de
                    Crédito</option>
                <option value="pix"
                    {{ isset($enrollment) && $enrollment->payment_type == 'pix' ? 'selected' : '' }}>PIX</option>
            </select>
        </div>
        <div class="col-12 col-md-6 form-group">
            <label for="status" class="form-label da-required">Status</label>
            @empty(Auth::user()->associate_id)
                <select name="status" class="form-control" id="status" required>
                    <option value="" selected="">Selecion...</option>
                    <option value="pending" {{ isset($enrollment) && $enrollment->status == 'pending' ? 'selected' : '' }}>
                        Pagamento Pendente</option>
                    <option value="approve" {{ isset($enrollment) && $enrollment->status == 'approve' ? 'selected' : '' }}>
                        Aprovado</option>
                    <option value="on-hold" {{ isset($enrollment) && $enrollment->status == 'on-hold' ? 'selected' : '' }}>
                        Aguardando</option>
                    <option value="cancelled"
                        {{ isset($enrollment) && $enrollment->status == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    <option value="refunded"
                        {{ isset($enrollment) && $enrollment->status == 'refunded' ? 'selected' : '' }}>Reembolsado
                    </option>
                    <option value="failed" {{ isset($enrollment) && $enrollment->status == 'failed' ? 'selected' : '' }}>
                        Malsucedido</option>
                    <option value="draft" {{ isset($enrollment) && $enrollment->status == 'draft' ? 'selected' : '' }}>Em
                        criação</option>
                </select>
            @else
                <input type="hidden" name="status" id="status" value="draft">
                <input type="text" class="form-control" disabled value="Em Criação">
            @endempty
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6 form-group">
            <label for="product" class="form-label da-required">Produtos</label>
            <select class="form-control" id="product">
                <option value="">Selecione...</option>
            </select>
            <small id="loading" style="display:none;">Carregando...</small>
        </div>
        <div class="col-12 col-md-2 form-group">
            <label class="form-label w-100">&nbsp;</label>
            <button type="button" class="btn btn-primary" id="btn_add">Adicionar</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped da-table" id="table_product">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Produto</th>
                        <th>Concluido</th>
                        <th>Cliente</th>
                        <th width="100" class="text-right">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($enrollment) && $enrollment->products)
                        @foreach ($enrollment->products as $prod)
                            <tr id="item_{{ $prod->id }}">
                                <input type="hidden" name="products[]" value="{{ $prod->id }}">
                                <td>{{ str_pad($prod->id, 8, 0, STR_PAD_LEFT) }}</td>
                                <td class="text-truncate">{{ $prod->name }}</td>
                                <td>{{ date('d/m/Y', strtotime($prod->conclude)) }}</td>
                                <td class="text-truncate">{{ $prod->client }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn_remove"
                                        data-remove="#item_{{ $prod->id }}">
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
                    @else
                        <tr id="empty">
                            <td colspan="4" class="text-center">Nenhum produto adicionado.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center mt-5">
            <input type="hidden" name="note_type" value="manual">
            <input type="hidden" name="note" value="{{ Auth::user()->name }} registrou a inscrição.">

            <a href="{{ route('enrollment.index') }}" class="btn btn-secondary" title="Voltar">Voltar</a>
            <button type="submit" class="btn btn-success" title="Salvar Alterações">Salvar e Continuar</button>
            @if(!empty(Auth::user()->associate_id))
            <button type="button" class="btn btn-danger" id="conclude_btn"
                title="Salvar e efetuar pagamento">Salvar e Finalizar</button>
            @endif
        </div>
    </div>

</div>

@push('scripts')
    <script src="{{ asset('assets/js/enrollment.js') }}"></script>

    <script>
        (function($) {
            $(function() {

                $('#associate').trigger('change');

                $('#conclude_btn').on('click', function(e) {
                    e.preventDefault();
                    const button = $(this);
                    Swal.fire({
                        icon: 'question',
                        title: 'Deseja realmente finalizar essa incrição e efetuar o pagamento?',
                        showCancelButton: true,
                        confirmButtonText: 'Sim',
                        cancelButtonText: `Não`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#form_enrollment').append('<input type="hidden" name="checkout" value="1">');
                            $('#status').val('pending');
                            $('#form_enrollment').submit();
                        }
                    })
                });

                $('.btn_remove').on('click', function(e) {
                    e.preventDefault();
                    let item = $(this).data('remove');
                    $(item).remove();
                });

            });
        })(jQuery);
    </script>


    @if (isset($enrollment) && $enrollment->status != 'draft')
        <script>
            (function($) {
                $(function() {
                    $('#award').prop('disabled', true);
                    //$('#associate').prop('disabled', true);
                    //$('#product').prop('disabled', true);
                    //$('#btn_add').prop('disabled', true);
                });
            })(jQuery);
        </script>
    @endif
@endpush
