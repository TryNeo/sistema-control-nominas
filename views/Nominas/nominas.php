<?php getHeader($data);
    getModal('modals_nominas',$data);
    getModal('modals_reporte_nominas',$data);
    getModal('modals_reporte_detalle',$data);
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
                <button onclick="return abrir_modal_nomina();" class="btn btn-outline-secondary btnModal"
                data-target="#modalNomina"><i class="fa fa-plus" aria-hidden="true"></i>
                Generar nueva nomina</button>     
            </div>
            <?php } ?>
            <?php  if ($_SESSION['permisos_modulo']['r']) {?>
                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-8 text-right">
                    <button onclick="return abrir_modal_reporte('modalReporteNomina');" class="btn btn-outline-primary" ><i class="fas fa-print" aria-hidden="true"></i>
                        Reporte nominas</button>
                </div>
            <?php } ?>
        
        </div>
        <hr>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table tableNomina table-striped  first display responsive" cellspacing="0"  style="width:100%">
                            <thead>
                                <th>ID</th>
                                <th>Nomina</th>
                                <th>Periodo de inicio</th>
                                <th>Periodo de fin</th>
                                <th>Estado nomina</th>
                                <th>total</th>
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