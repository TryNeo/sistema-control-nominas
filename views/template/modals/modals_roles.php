<div class="modal fade" id="modalRol" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Nuevo Rol <i class=" fas fa-clipboard-list"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formRol" name="formRol">
            <div class="card-body row">
                    <div class="col-md-9 mb-3">
                        <label class="control-label">Nombre rol:</label>
                        <input type="text" name="rolInput" class="form-control" id="rolInput" placeholder="ingrese nombre de rol">
                    </div>
                    <div class="col-9 col-lg-10">
                        <label class="control-label">Descripcion:</label>
                        <textarea name="descriInput" cols="30" rows="3" maxlength="250" class="form-control"  placeholder="ingrese la descripcion" id="descriInput"></textarea>
                    </div>
                    <div class="col-md-9 mb-3">
                        <label class="control-label">Estado:</label>
                        <select class="form-control" id="estadoInput" name="estadoInput">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Guardar Registro</button>
                <button type="reset" class="btn btn-primary" name="reset"> <i class="fas fa-undo"></i>Limpiar Registro</button>                    
                <button type="button" class="btn btn-danger" onclick="return cerrar_modal('modalRol')"><i class=" fas fa-exclamation-circle"></i> Cancelar</button>  
        </form>
      </div>
    </div>
  </div>
</div>