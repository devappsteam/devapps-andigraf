<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-md-6 form-group">
            <label for="award" class="form-label da-required">Premiação</label>
            <select name="award" class="form-control" id="award" required>
                <option value="">Selecione...</option>
                @if (isset($awards))
                    @foreach ($awards as $award)
                        <option value="{{ $award->id }}" {{ (isset($product) && $product->award_id == $award->id) ? "selected" : "" }}>
                            {{ $award->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-12 col-md-6 form-group">
            <label for="associate" class="form-label da-required">Associado</label>
            <select name="associate" class="form-control" id="associate" required>
                <option value="">Selecione...</option>
                @if (isset($associates))
                    @foreach ($associates as $associate)
                        <option value="{{ $associate->id }}" {{ (isset($product) && $product->associate_id == $associate->id) ? "selected" : "" }}>
                            @if ($associate->type == "legal")
                                {{ $associate->fantasy_name }}
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
        <div class="col-12 form-group">
            <label for="name" class="form-label da-required">Nome do produto</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $product->name ?? old('name') }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-4 form-group">
            <label for="category" class="form-label da-required">Categoria</label>
            <select name="category" class="form-control" id="category" required>
                <option value="" selected>Selecione...</option>
                @if (isset($categories))
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ (isset($product) && $product->product_category_id == $category->id) ? "selected" : "" }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-12 col-md-4 form-group">
            <label for="client" class="form-label da-required">Nome do Cliente</label>
            <input type="text" name="client" class="form-control" id="client" value="{{ $product->client ?? old('client') }}" required>
        </div>
        <div class="col-12 col-md-4 form-group">
            <label for="conclude" class="form-label da-required">Data de Conclusão</label>
            <input type="date" name="conclude" class="form-control" id="conclude" value="{{ $product->conclude ?? old('conclude') }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-12 form-group">
            <label for="print_process" class="form-label da-required">Processo de Impressão</label>
            <div class="w-100">
                @if(isset($print_processes))
                    @php
                            $p_processes = [];
                    @endphp
                    @if (isset($product))
                        @php
                            $p_processes = $product->print_processes;
                        @endphp
                    @endif
                    @foreach ($print_processes as $print_process)
                        @php
                            $checked = "";
                        @endphp
                        @if (count($p_processes) > 0)
                            @foreach ($p_processes as $p_process)
                                @if ($p_process->id == $print_process->id)
                                    @php
                                        $checked = "checked";
                                    @endphp
                                @endif
                            @endforeach
                        @endif
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="print_process[]" id="print_process_{{ $print_process->id }}" value="{{ $print_process->id }}" {{ $checked }}>
                            <label class="form-check-label" for="print_process_{{ $print_process->id }}">{{ $print_process->name }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 form-group">
            <label for="special_features" class="form-label da-required">Recursos Especiais</label>
            <textarea name="special_features" class="form-control" id="special_features" rows="5" required>{{ $product->special_features ?? old('special_features')}}</textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-12 form-group">
            <label for="substrate" class="form-label da-required">Substrato</label>
            <textarea name="substrate" class="form-control" id="substrate" rows="5" required>{{ $product->substrate ?? old('substrate')}}</textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-12 form-group">
            <label for="note" class="form-label">Observações</label>
            <textarea name="note" class="form-control" id="note" rows="5">{{ $product->note ?? old('note')}}</textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center mt-5">
            <button type="submit" class="btn btn-success" title="Salvar Alterações">Salvar</button>
            <a href="{{ route('product.index') }}" class="btn btn-secondary" title="Voltar">Voltar</a>
        </div>
    </div>

</div>

@push('scripts')
@endpush
