<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Creacion de nuevo Usuario <i class="fas fa-clipboard-list"></i></h5>
      </div>
      <div class="modal-body">
        <form id="formUsuario" name="formUsuario" enctype="multipart/form-data"">
            <input type="hidden" id="id_usuario" name="id_usuario" value="">
            <div class="card-body row">
              <div class="col-md-6 mb-3">
                <label class="col-form-label text-right" for="nombre">Nombre:</label>
                <div class="input-group mb-3">
                  <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-address-book"></i></span></span>
                  <input type="text" name="nombre" class="form-control" id="nombre" placeholder="ingrese el nombre">
                </div>
              </div>
              <div class="col-md-6 mb-3">
                  <label class="col-form-label text-right" for="apellido">Apelido:</label>
                  <div class="input-group mb-3">
                    <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-address-book"></i></span></span>
                    <input type="text" name="apellido" class="form-control" id="apellido" placeholder="ingrese el apellido">
                  </div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="col-form-label text-right" for="usuario">Usuario:</label>
                  <div class="input-group mb-3">
                    <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></span>
                    <input type="text" name="usuario" class="form-control" id="usuario"  placeholder="ingrese el usuario">
                  </div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="col-form-label text-right" for="email">Email:</label>
                <div class="input-group mb-3">
                  <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></span>
                  <input type="email" name="email" class="form-control" id="email" required placeholder="ingrese el email">
                  <span id="emailOK" class="validate-Error"></span>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="col-form-label text-right" for="password">Contraseña:</label>
                <div class="input-group mb-3">
                  <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></span>
                  <input type="password" name="password" class="form-control" id="password"  placeholder="ingrese la contraseña">
                </div>
              </div>
              <div class="col-md-6 mb-3">
                  <label class="col-form-label text-right" for="id_rol">Rol:</label>
                  <div class="input-group mb-3">
                    <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-list-ul"></i></span></span>
                    <select class="form-control" id="id_rol" name="id_rol">
                    </select>
                  </div>
              </div>
              <div class="col-md-6 mb-3">
                  <label class="col-form-label text-right" for="estadoInput">Estado:</label>
                  <div class="input-group mb-3">
                    <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-toggle-on"></i></span></span>
                    <select class="form-control" id="estadoInput" name="estadoInput">
                            <option  selected disabled="disabled" value="">Seleciona el estado</option>
                            <option value="1" >Activo</option>
                            <option value="0">Inactivo</option>
                    </select>
                  </div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="col-form-label text-right" for="foto">Foto de perfil:</label>
                <div class="input-group mb-3">
                  <span class="input-group-prepend"><span class="input-group-text"><a href="#" onclick="return abrir_modal_imagen();"><i class="fas fa-image"></i></a></span></span>
                  <input type="file" class="inputfile inputfile-1" name="foto" id="foto">
                  <label for="foto" class="label-image"><span class="borrarinputfile">Seleccionar imagen</span></label>    
                </div>
              </div>
            
            </div>
            <div class="col-md-12 mb-3">
              <button type="submit" class="btn btn-info"><i class="fas fa-save"></i><span class="text-center"> Guardar Registro</span></button>
              <button type="reset" class="btn btn-primary " id="btnDisabled" name="reset"> <i class="fas fa-undo"></i>Limpiar Registro</button>                    
              <button type="button" class="btn btn-danger" onclick="return cerrar_modal('#modalUsuario')"><i class=" fas fa-exclamation-circle"></i> Cancelar</button>  
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="imagenModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div id="ImagePreview" align="center"></div>
    </div>
  </div>
</div>