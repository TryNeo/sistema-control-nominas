<div class="modal fade" id="modalEmpleado" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Creacion de nuevo Empleado <i class="fas fa-clipboard-list"></i></h5>
      </div>
      <div class="modal-body">
        <form id="formEmpleado" name="formEmpleado" >
            <input type="hidden" id="id_empleado" name="id_empleado" value="">
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
                    <label class="col-form-label text-right" for="sueldo">Cedula:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-id-card"></i></span></span>
                        <input type="text" name="cedula" class="form-control cedula-inputmask" id="cedula" im-insert="true  placeholder="ingrese la cedula">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="col-form-label text-right" for="email">Email:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></span>
                        <input type="email" name="email" class="form-control" id="email" placeholder="ingrese el email">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="col-form-label text-right" for="sueldo">Telefono:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></span>
                        <input type="text" name="telefono" class="form-control phone-inputmask" im-insert="true" id="telefono" placeholder="ingrese el numero de telefono">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="col-form-label text-right" for="sueldo">Sueldo:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign"></i></span></span>
                        <input type="number" step="any" name="sueldo" class="form-control " id="sueldo"  placeholder="ingrese el sueldo">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="col-form-label text-right" for="id_contracto">Tipos de contracto:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-list-ul"></i></span></span>
                        <select class="form-control" id="id_contracto"  name="id_contracto">
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
            </div>
            <div class="col-md-12 mb-3">
                <button type="submit" class="btn btn-info"><i class="fas fa-save"></i><span class="text-center"> Guardar Registro</span></button>
                <button type="reset" class="btn btn-primary " id="btnDisabled" name="reset"> <i class="fas fa-undo"></i> Limpiar Registro</button>                    
                <button type="button" class="btn btn-danger" onclick="return cerrar_modal('#modalEmpleado')"><i class=" fas fa-exclamation-circle"></i> Cancelar</button>  
            </div>
        </form>
    </div>
    </div>
  </div>
</div>