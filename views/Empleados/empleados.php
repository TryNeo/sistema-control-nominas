<?php getHeader($data); 
    getModal('modals_empleados',$data);
    getModal('modals_reporte_empleado',$data);
?>
<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header" id="top">
                    <h2 class="pageheader-title text-center"><?php echo $data["page_name"];?></h2>
                </div>
            </div>
            <?php  if ($_SESSION['permisos_modulo']['w']) {?>
            <div class="col-xl-8 col-lg-4 col-md-4 col-sm-4 col-4">
                <button onclick="return abrir_modal_empleado();" class="btn btn-outline-secondary btnModal" data-target="#modalEmpleado"><i class="fa fa-plus" aria-hidden="true"></i>
                Añadir nuevo empleado</button>     
            </div>
            <?php } ?>

            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-8 text-right">
                <button onclick="return abrir_modal_reporte('modalReporteEmpleado');" class="btn btn-outline-primary" ><i class="fas fa-print" aria-hidden="true"></i>
                    Reporte empleados</button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table tableEmpleado table-striped  first display responsive" cellspacing="0"  style="width:100%">
                            <thead>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cedula</th>
                                <th>Telefono</th>
                                <th>Sueldo</th>
                                <th>Puesto</th>
                                <th>Contrato</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
getScripts($data);?>