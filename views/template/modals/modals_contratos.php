<div class="modal fade" id="modalContrato" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Creacion de nuevo contrato <i class="fas fa-clipboard-list"></i></h5>
      </div>
      <div class="modal-body">
        <form id="formContrato" name="formContrato">
          <input id="csrf" name="csrf" type="hidden" value="<?php echo $data["csrf"]; ?>">
            <div class="card-body row">
                    <input type="hidden" id="id_contrato" name="id_contrato" value="">
                    <div class="col-md-10 mb-3">
                        <label class="control-label">Nombre contrato:</label>
                      <div class="input-group mb-3">
                        <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-book"></i></span></span>
                        <input type="text" name="nombre_contrato" class="form-control" id="nombre_contrato"  placeholder="ingrese nombre del contrato">
                      </div>
                    </div>
                    <div class="col-md-10 mb-3">
                        <label class="control-label">Descripcion:</label>
                        <textarea name="descripcion" cols="30" rows="3" maxlength="250"  class="form-control" placeholder="ingrese la descripcion" id="descripcion"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="control-label">Estado:</label>
                        <div class="input-group mb-3">
                          <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-toggle-on"></i></span></span>
                          <select class="form-control" id="estadoInput" name="estadoInput">
                              <option  selected disabled="disabled" value="">Seleciona el estado</option>
                              <option value="1" >Activo</option>
                              <option value="0">Inactivo</option>
                          </select>
                        </div>
                    </div>
            </div>
            <div class="col-md-12 mb-3">
              <button id="btnActionForm"type="submit" class="btn btn-info"><i class="fas fa-save"></i><span class="text-center"> Guardar Registro</span></button>
              <button type="reset" class="btn btn-primary " id="btnDisabled" name="reset"> <i class="fas fa-undo"></i> Limpiar Registro</button>                    
              <button type="button" class="btn btn-danger" onclick="return cerrar_modal('#modalContrato')"><i class=" fas fa-exclamation-circle"></i> Cancelar</button>  
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
