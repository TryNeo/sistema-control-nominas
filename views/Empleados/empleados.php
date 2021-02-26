<?php getHeader($data); 
    getModal('modals_empleados',$data);

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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <button onclick="return abrir_modal_empleado();" class="btn btn-outline-secondary btnModal" data-target="#modalEmpleado"><i class="fa fa-plus" aria-hidden="true"></i>
                Añadir nuevo empleado</button>     
            </div>
            <?php } ?>
        </div>
        <hr>
    </div>
</div>
<?php 
getScripts($data);?>