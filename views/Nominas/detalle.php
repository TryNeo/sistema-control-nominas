<?php  
getHeader($data);
?>
<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <form class="formDetalleNomina">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Detalle de <?php echo $data["data_nomina"]["nombre_nomina"]; ?>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="row">
                                        <input type="hidden" id="id_nomina" name="id_nomina" value="<?php echo $data["data_nomina"]["id_nomina"]; ?>">
                                        <div class="col-md-4 form-group">
                                            <label class="control-label">Nombre nomina: </label>
                                            <input type="text" class="form-control" value="<?php echo $data["data_nomina"]["nombre_nomina"]; ?>"name="nombre_nomina" id="nombre_nomina">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="control-label">Periodo Inicio: </label>
                                            <input type="text" disabled class="form-control" value="<?php echo $data["data_nomina"]["periodo_inicio"]; ?>"name="periodo_inicio" id="periodo_inicio">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="control-label">Periodo Fin: </label>
                                            <input type="text" disabled class="form-control" value="<?php echo $data["data_nomina"]["periodo_fin"]; ?>"name="periodo_fin" id="periodo_fin">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="control-label">Buscar empleado:</label>
                                            <select class="form-control select2" style="width:100%;" id="SearchEmpl"></select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="control-label">Estado nomina:</label>
                                            <select class="form-control" id="estado_nomina" name="estado_nomina">
                                                <option  selected disabled="disabled" value="">Seleciona el estado de nomina</option>
                                                <?php if ($data['data_nomina']['estado_nomina'] == 1) {?>
                                                    <option selected value="1">Pediente</option>
                                                    <option value="2">Aceptado</option>
                                                    <option value="3">Rechazado</option>
                                                <?php }else if($data['data_nomina']['estado_nomina'] == 2){?>
                                                    <option value="1">Pediente</option>
                                                    <option selected value="2">Aceptado</option>
                                                    <option value="3">Rechazado</option>
                                                <?php }else if($data['data_nomina']['estado_nomina'] == 3){?>
                                                    <option value="1">Pediente</option>
                                                    <option value="2">Aceptado</option>
                                                    <option selected value="3">Rechazado</option>
                                                <?php }?>
                                            </select>
                                        </div> 
                                        <div class="col-md-8">
                                                <table id="tableNominaEmpleado" class="table table-striped  first display responsive" cellspacing="0"  style="width:100%">
                                                    <thead>
                                                        <th>ID</th>
                                                        <th>Nombres</th>
                                                        <th>Apellidos</th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>

                                    <!---
                                    <div class="row">  
                                    <label class="control-label" >Buscar empleado:</label>
                                            <div class="form-group">
                                                <select class="form-control select2" style="width:30%;" id="SearchEmpl"></select>
                                            </div>    
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="col-sm-8 col-8">
                                                <table id="tableNominaEmpleado" class="table table-striped  first display responsive" cellspacing="0"  style="width:100%">
                                                    <thead>
                                                        <th>ID</th>
                                                        <th>Nombres</th>
                                                        <th>Apellidos</th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    ---->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </form>
    </div>
</div>
<?php 
getScripts($data);?>