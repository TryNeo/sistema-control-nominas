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
                                    <div class="dropdown-divider"></div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="">Nombre nomina: </label>
                                            <input type="text" disabled class="form-control" value="<?php echo $data["data_nomina"]["nombre_nomina"]; ?>"name="nombre_nomina" id="nombre_nomina">
                                        </div>
                                    </div>
                                    <?php dep($data['data_nomina']);?>

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