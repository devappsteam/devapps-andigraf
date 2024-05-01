<div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 form-group">
                <label for="name" class="form-label da-required">Nome</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $user->name ?? old('name') }}" required>
            </div>
            <div class="col-12 col-md-6 form-group">
                <label for="email" class="form-label da-required">E-mail</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ $user->email ?? old('email') }}" required>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 form-group">
                <label for="name" class="form-label da-required">Senha</label>
                <input type="password" name="password" class="form-control" minlength="6" id="password">
            </div>
            <div class="col-12 col-md-6 form-group">
                <label for="confirm_password" class="form-label da-required">Confirmar Senha</label>
                <input type="password" name="confirm_password" class="form-control" minlength="6" id="confirm_password">
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

