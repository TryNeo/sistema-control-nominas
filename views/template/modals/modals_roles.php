<div class="modal fade" id="modalRol" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Creacion de nuevo rol <i class=" fas fa-clipboard-list"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formRol">
            <div class="card-body row">
                    <input type="hidden" id="id_rol" name="id_rol" value="">
                    <div class="col-md-10 mb-3">
                        <label class="control-label">Nombre rol:</label>
                        <input type="text" name="rolInput" class="form-control" id="rolInput" required placeholder="ingrese nombre de rol">
                    </div>
                    <div class="col-md-10 mb-3">
                        <label class="control-label">Descripcion:</label>
                        <textarea name="descriInput" cols="30" rows="3" maxlength="250" class="form-control" placeholder="ingrese la descripcion" id="descriInput"></textarea>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="control-label">Estado:</label>
                        <select class="form-control" id="estadoInput" name="estadoInput">
                            <option  selected disabled="disabled" value="">Seleciona el estado</option>
                            <option value="1" >Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
            </div>
            <div class="col-md-12 mb-3">
              <button id="btnActionForm"type="submit" class="btn btn-info"><i class="fas fa-save"></i><span class="text-center">Guardar Registro</span></button>
              <button type="reset" class="btn btn-primary " id="btnDisabled" name="reset"> <i class="fas fa-undo"></i>Limpiar Registro</button>                    
              <button type="button" class="btn btn-danger" onclick="return cerrar_modal('#modalRol')"><i class=" fas fa-exclamation-circle"></i> Cancelar</button>  
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade modalPermisos" tabindex="-1" role="dialog">
  <div class="modal-dialog  modal-lg  modal-dialog-centered"  role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Permisos roles usuario <i class=" fas fa-clipboard-list"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" id="formPermisos" name="formPermisos">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card-body">
              <table class="table  first display responsive nowrap" cellspacing="0"  style="width:100%">
                <thead>
                  <th>#</th>
                  <th>Modulo</th>
                  <th>Leer</th>
                  <th>Escribir</th>
                  <th>Actualizar</th>
                  <th>eliminar</th>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>usuarios</td>
                    <td>
                    <div class="switch-button switch-button-xs switch-button-success">
                    <input type="checkbox" checked="" name="switch16" id="switch16"><span>
                    <label for="switch16"></label></span>
                    </div>
                    </td>
                  </tr>
                </tbody>
                </table>
            </div>
                <div class="col-md-12 mb-3 text-center">
                  <button type="submit" class="btn btn-info"><i class="fas fa-save"></i><span class="text-center">Guardar</span></button>
                  <button type="button" class="btn btn-danger" onclick="return cerrar_modal('.modalPermisos')"><i class=" fas fa-exclamation-circle"></i> Cancelar</button>  
                </div>
            </div>
      </form>
      </div>
    </div>
  </div>
</div>
