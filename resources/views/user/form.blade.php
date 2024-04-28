<div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12 form-group">
                <label for="name" class="form-label da-required">Nome</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $user->name ?? old('name') }}" required>
            </div>
            <div class="col-12 col-md-8 form-group">
                <label for="email" class="form-label da-required">E-mail</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ $user->email ?? old('email') }}" required>
            </div>
            <div class="col-12 col-md-4 form-group">
                <label for="associate" class="form-label">Associado</label>
                <select name="associate" class="form-control" id="associate">
                    <option value="">Selecione...</option>
                    @if (isset($associates))
                        @foreach ($associates as $associate)
                            <option value="{{ $associate->id }}" {{ (isset($user) && $user->associate_id == $associate->id) ? "selected" : "" }}>
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
            <div class="col-12 col-md-6 form-group">
                <label for="name" class="form-label da-required">Senha</label>
                <input type="password" name="password" class="form-control" minlength="6" id="password" required>
            </div>
            <div class="col-12 col-md-6 form-group">
                <label for="confirm_password" class="form-label da-required">Confirmar Senha</label>
                <input type="password" name="confirm_password" class="form-control" minlength="6" id="confirm_password" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center mt-5">
            <button type="submit" class="btn btn-success" title="Salvar Alterações">Salvar</button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary" title="Voltar">Voltar</a>
        </div>
    </div>
</div>

