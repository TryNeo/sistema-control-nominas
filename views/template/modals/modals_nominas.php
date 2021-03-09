<div class="modal fade" id="modalNomina" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Generar nueva nomina <i class="fas fa-id-badge"></i></h5>
        </div>
        <div class="modal-body">
            <form id="formNomina" name="formNomina">
                <div class="card-body row">
                        <input type="hidden" id="id_nomina" name="id_nomina" value="">
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
                <button id="btnActionForm"type="submit" class="btn btn-primary"><i class="fas fa-save"></i><span class="text-center">Generar Registro</span></button>
                <button type="button" class="btn btn-danger" onclick="return cerrar_modal('#modalNomina')"><i class=" fas fa-exclamation-circle"></i> Cancelar</button>  
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
