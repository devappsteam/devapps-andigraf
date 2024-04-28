 <div class="container-fluid">
     <div class="row">
         <div class="col-12 form-group">
             <label for="name" class="form-label da-required">Nome</label>
             <input type="text" name="name" class="form-control" id="name" title="Nome" value="{{ $award->name ?? old('name') }}" required>
         </div>
     </div>
     <div class="row">
         <div class="col-12 col-md-4 form-group">
             <label for="start" class="form-label da-required">Inicio</label>
             <input type="date" name="start" class="form-control" id="start" title="Data de inicio" value="{{ $award->start ?? old('start') }}" required>
         </div>
         <div class="col-12 col-md-4 form-group">
             <label for="end" class="form-label da-required">Fim</label>
             <input type="date" name="end" class="form-control" id="end" title="Data final" value="{{ $award->end ?? old('end') }}" required>
         </div>
         <div class="col-12 col-md-4 form-group">
            <label for="discount" class="form-label da-required">Número de peças gratuitas</label>
            <input type="number" name="discount" class="form-control" id="discount" title="Número de produtos grátis na primeira inscrição" min="0" max="10" value="{{ $award->discount ?? old('discount') }}" required>
        </div>
     </div>
     <div class="row">
         <div class="col-12 form-group">
             <label for="description" class="form-label">Descrição</label>
             <textarea name="description" class="form-control" id="description" cols="30" rows="10" title="Descrição">{{ $award->description ?? old('description') }}</textarea>
         </div>
     </div>
     <div class="row">
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-success" title="Salvar Alterações">Salvar</button>
            <a href="{{ route('award.index') }}" class="btn btn-secondary" title="Voltar">Voltar</a>
        </div>
    </div>
 </div>
