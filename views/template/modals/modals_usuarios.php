<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Creacion de nuevo Usuario <i class=" fas fa-clipboard-list"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formUsuario">
            <div class="card-body row">
              <div class="col-md-6 mb-3">
                <label class="col-form-label text-right">Nombre:</label>
                <input type="text" name="nombre" class="form-control" id="nombre" required placeholder="ingrese nombre de usuario">
              </div>
              <div class="col-md-6 mb-3">
                <label class="col-form-label text-right">Apelido:</label>
                <input type="text" name="apellido" class="form-control" id="apellido" required placeholder="ingrese apellido de usuario">
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <button type="submit" class="btn btn-info"><i class="fas fa-save"></i><span class="text-center">Guardar Registro</span></button>
              <button type="reset" class="btn btn-primary " id="btnDisabled" name="reset"> <i class="fas fa-undo"></i>Limpiar Registro</button>                    
              <button type="button" class="btn btn-danger" onclick="return cerrar_modal('#modalUsuario')"><i class=" fas fa-exclamation-circle"></i> Cancelar</button>  
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
