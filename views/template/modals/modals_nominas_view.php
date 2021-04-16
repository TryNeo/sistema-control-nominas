<div class="modal fade" id="modalViewNomina" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div   div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Informacion de la nomina <i class="fas fa-eye"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body row">
                    <div class="col-md-12 mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-book"></i></span></span>
                            <input type="text" name="nombre_nomina" disabled class="form-control" id="nombre_nomina">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></span>
                            <input type="text" name="periodo_inicio" disabled class="form-control" id="periodo_inicio">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text"><i class="far fa-calendar-alt"></i></span></span>
                            <input type="text" name="periodo_fin" disabled class="form-control" id="periodo_fin">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                        <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-toggle-on"></i></span></span>
                        <select class="form-control" disabled id="estado_nomina" name="estado_nomina">
                            <option  selected disabled="disabled" value="">Seleciona el estado de nomina</option>
                            <option value="1">Pendiente</option>
                            <option value="2">Aceptado</option>
                            <option value="3">Rechazado</option>
                        </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group mb-3">
                            <span class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign"></i></span></span>
                            <input type="text" name="total" disabled class="form-control" id="total">
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <table id="tableViewNomina" class="table table-striped  first display responsive" cellspacing="0"  style="width:100%">
                        <thead>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Puesto</th>
                            <th>Sueldo</th>
                            <th>Meses</th>
                            <th>Total</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>
    </div>
</div>
