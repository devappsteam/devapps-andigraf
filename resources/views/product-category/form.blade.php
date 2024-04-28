 <div class="container-fluid">
     <div class="row">
         <div class="col-12 form-group">
             <label for="name" class="form-label da-required">Nome</label>
             <input type="text" name="name" class="form-control" id="name" title="Nome" value="{{ $data->name ?? old('name') }}" required>
         </div>
     </div>
     <div class="row">
         <div class="col-12 form-group">
             <label for="description" class="form-label">Descrição</label>
             <textarea name="description" class="form-control" id="description" cols="30" rows="10" title="Descrição">{{ $data->description ?? old('description') }}</textarea>
         </div>
     </div>
     <div class="row">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success" title="Salvar Alterações">Salvar</button>
            <a href="{{ route('product.category.index') }}" class="btn btn-secondary" title="Voltar">Voltar</a>
        </div>
    </div>
 </div>
