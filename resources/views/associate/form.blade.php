<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <label for="type" class="form-label da-required">Tipo de Associado</label>
        </div>
        <div class="col-12 form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="legal" value="legal" {{ (isset($associate) && $associate->type == "legal") ? "checked" : "" }}>
                <label class="form-check-label" for="legal">Pessoa Jurídica</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type" id="physical" value="physical" {{ (isset($associate) && $associate->type == "physical") ? "checked" : "" }}>
                <label class="form-check-label" for="physical">Pessoa Física</label>
            </div>
        </div>
    </div>

    <div class="personal" style="{{ (isset($associate) && $associate->type == "legal") ? "display: none;" : "" }}">
        <div class="row">
            <div class="col-12 col-md-4 form-group">
                <label for="personal_document" class="form-label da-required">CPF</label>
                <input type="text" name="personal_document" class="form-control" id="personal_document" title="Documento" value="{{ $associate->document ?? old('document') }}" data-mask="000.000.000-00">
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-4 form-group">
                <label for="first_name" class="form-label da-required">Nome</label>
                <input type="text" name="first_name" class="form-control" id="first_name" value="{{ $associate->first_name ?? old('first_name') }}">
            </div>
            <div class="col-12 col-md-4 form-group">
                <label for="last_name" class="form-label da-required">Sobrenome</label>
                <input type="text" name="last_name" class="form-control" id="last_name" value="{{ $associate->last_name ?? old('last_name') }}">
            </div>
            <div class="col-12 col-md-4 form-group">
                <label for="birth_date" class="form-label da-required">Data de Nascimento</label>
                <input type="date" name="birth_date" class="form-control" id="birth_date" value="{{ $associate->birth_date ?? old('birth_date') }}">
            </div>
        </div>
    </div>

    <div class="corporate" style="{{ (isset($associate) && $associate->type == "legal") ? "" : "display: none;" }}">
        <div class="row">
            <div class="col-12 col-md-4 form-group">
                <label for="corporate_document" class="form-label da-required">CNPJ</label>
                <input type="text" name="corporate_document" class="form-control" id="corporate_document" title="Documento" value="{{ $associate->document ?? old('document') }}" data-mask="00.000.000/0000-00" required>
            </div>
            <div class="col-12 col-md-2 form-group">
                <label class="form-label w-100">&nbsp;</label>
                <button type="button" class="btn btn-primary" id="find_cnpj">Buscar Empresa</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 form-group">
                <label for="corporate_name" class="form-label da-required">Razão Social</label>
                <input type="text" name="corporate_name" class="form-control" id="corporate_name" value="{{ $associate->corporate_name ?? old('corporate_name') }}" required>
            </div>
            <div class="col-12 col-md-6 form-group">
                <label for="fantasy_name" class="form-label da-required">Nome Fantasia</label>
                <input type="text" name="fantasy_name" class="form-control" id="fantasy_name" value="{{ $associate->fantasy_name ?? old('fantasy_name') }}" required>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 form-group">
                <label for="state_registration" class="form-label">Inscrição Estadual</label>
                <input type="text" name="state_registration" class="form-control" id="state_registration" value="{{ $associate->state_registration ?? old('state_registration') }}">
            </div>
            <div class="col-12 col-md-6 form-group">
                <label for="municipal_registration" class="form-label">Inscrição Municipal</label>
                <input type="text" name="municipal_registration" class="form-control" id="municipal_registration" value="{{ $associate->municipal_registration ?? old('municipal_registration') }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-4 form-group">
            <label for="phone" class="form-label da-required">Telefone</label>
            <input type="text" name="phone" class="form-control" id="phone" value="{{ $associate->phone ?? old('phone') }}" required>
        </div>
        <div class="col-12 col-md-4 form-group">
            <label for="email" class="form-label da-required">E-mail</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ $associate->email ?? old('email') }}" required>
        </div>
        <div class="col-12 col-md-4 form-group">
            <label for="whatsapp" class="form-label">WhatsApp</label>
            <input type="text" name="whatsapp" class="form-control" id="whatsapp" value="{{ $associate->whatsapp ?? old('whatsapp') }}">
        </div>
    </div>

    <div class="corporate" style="{{ (isset($associate) && $associate->type == "legal") ? "" : "display: none;" }}">
        <div class="row">
            <div class="col-12">
                <h4 class="mt-4">Responsável</h4>
            </div>
            <div class="col-12 col-md-4 form-group">
                <label for="responsible_first_name" class="form-label da-required">Nome</label>
                <input type="text" name="responsible_first_name" class="form-control" id="responsible_first_name" value="{{ $associate->responsible_first_name ?? old('responsible_first_name') }}" required>
            </div>
            <div class="col-12 col-md-4 form-group">
                <label for="responsible_last_name" class="form-label da-required">Sobrenome</label>
                <input type="text" name="responsible_last_name" class="form-control" id="responsible_last_name" value="{{ $associate->responsible_last_name ?? old('responsible_last_name') }}" required>
            </div>
            <div class="col-12 col-md-4 form-group">
                <label for="responsible_phone" class="form-label da-required">Telefone</label>
                <input type="text" name="responsible_phone" class="form-control" id="responsible_phone" value="{{ $associate->responsible_phone ?? old('responsible_phone') }}" required>
            </div>
            <div class="col-12 col-md-6 form-group">
                <label for="responsible_email" class="form-label da-required">E-mail</label>
                <input type="email" name="responsible_email" class="form-control" id="responsible_email" value="{{ $associate->responsible_email ?? old('responsible_email') }}" required>
            </div>
            <div class="col-12 col-md-6 form-group">
                <label for="responsible_job" class="form-label da-required">Cargo</label>
                <input type="text" name="responsible_job" class="form-control" id="responsible_job" value="{{ $associate->responsible_job ?? old('responsible_job') }}" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4 class="mt-4">Redes Sociais</h4>
        </div>
        <div class="col-12 col-md-3 form-group">
            <label for="social_facebook" class="form-label">Facebook</label>
            <input type="text" name="social_facebook" class="form-control" id="social_facebook" value="{{ $associate->social_facebook ?? old('social_facebook') }}">
        </div>
        <div class="col-12 col-md-3 form-group">
            <label for="social_instagram" class="form-label">Instagram</label>
            <input type="text" name="social_instagram" class="form-control" id="social_instagram" value="{{ $associate->social_instagram ?? old('social_instagram') }}">
        </div>
        <div class="col-12 col-md-3 form-group">
            <label for="social_twitter" class="form-label">Twitter</label>
            <input type="text" name="social_twitter" class="form-control" id="social_twitter" value="{{ $associate->social_twitter ?? old('social_twitter') }}" >
        </div>
        <div class="col-12 col-md-3 form-group">
            <label for="social_youtube" class="form-label">YouTube</label>
            <input type="text" name="social_youtube" class="form-control" id="social_youtube" value="{{ $associate->social_youtube ?? old('social_youtube') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4 class="mt-4">Endereço</h4>
        </div>
        <div class="col-12 col-md-3 form-group">
            <label for="postcode" class="form-label da-required">CEP</label>
            <input type="text" name="postcode" class="form-control" id="postcode" value="{{ $associate->postcode ?? old('postcode') }}" data-mask="00000-000" required>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 form-group">
            <label for="address" class="form-label da-required">Endereço</label>
            <input type="text" name="address" class="form-control" id="address" value="{{ $associate->address ?? old('address') }}" required>
        </div>
        <div class="col-12 col-md-3 form-group">
            <label for="number" class="form-label">Número</label>
            <input type="text" name="number" class="form-control" id="number" value="{{ $associate->number ?? old('number') }}">
        </div>
        <div class="col-12 col-md-3 form-group">
            <label for="complement" class="form-label">Complemento</label>
            <input type="text" name="complement" class="form-control" id="complement" value="{{ $associate->complement ?? old('complement') }}">
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-3 form-group">
            <label for="district" class="form-label da-required">Bairro</label>
            <input type="text" name="district" class="form-control" id="district" value="{{ $associate->district ?? old('district') }}" required>
        </div>
        <div class="col-12 col-md-3 form-group">
            <label for="city" class="form-label da-required">Cidade</label>
            <input type="text" name="city" class="form-control" id="city" value="{{ $associate->city ?? old('city') }}" required>
        </div>
        <div class="col-12 col-md-3 form-group">
            <label for="state" class="form-label da-required">Estado</label>
            <input type="text" name="state" class="form-control" id="state" value="{{ $associate->state ?? old('state') }}" maxlength="2" required>
        </div>
        <div class="col-12 col-md-3 form-group">
            <label for="country" class="form-label">País</label>
            <input type="text" name="country" class="form-control" id="country" value="BR" disabled>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center mt-5">
            <button type="submit" class="btn btn-success" title="Salvar Alterações">Salvar</button>
            @if(Auth::check())
                @if(empty(Auth::user()->associate_id))
                    <a href="{{ route('associate.index') }}" class="btn btn-secondary" title="Voltar">Voltar</a>
                @else
                    <a href="{{ route('painel') }}" class="btn btn-secondary" title="Voltar">Voltar</a>
                @endif
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/associate.js') }}"></script>
@endpush
