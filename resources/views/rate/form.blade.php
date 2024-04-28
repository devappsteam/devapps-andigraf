 <div class="container-fluid">
        <input type="hidden" name="award" value="{{ $request->award }}">
     <div class="row">
         <div class="col-12">
            <div class="alert alert-primary font-weight-bold">Informe as taxas a serem aplicadas na premiação.</div>
         </div>
     </div>
     <div class="row">
         <div class="col-12 col-md-6 form-group">
             <label for="quantity" class="form-label da-required">Quantidade</label>
             <input type="text" name="quantity" class="form-control" id="quantity" title="Qauntidade" required>
         </div>
         <div class="col-12 col-md-6 form-group">
             <label for="price" class="form-label da-required">Preço Unitário</label>
             <input type="text" name="price" class="form-control" id="price" title="Preço" required>
         </div>
     </div>
 </div>
