<?php getHeader($data);
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <button type="button" id="backupbd" class="btn btn-outline-primary">
                Realizar copia de seguridad <i class="fa fa-download" aria-hidden="true"></i>
                </button>     
            </div>
            <?php } ?>
        </div>
        <hr>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header text-size">
                    <i class="fa fa-database" aria-hidden="true"></i> Listado de las copias de la base de datos
                    </div>
                    <div class="card-body">
                        <table class="table tableRespaldo table-striped  first display responsive nowrap" cellspacing="0"  style="width:100%">
                            <thead>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header text-size">
                    <i class="fas fa-paste"></i> Información para la restauración de la base de datos 
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>

        <!----
        <form id="formRestore" name="formRestore">
            <select class="form-control " id="restorebd" name="restorebd">
            </select>
            <button type="submit" id="restore">a</button>
        </form>
        --->
    </div>
</div>
<?php getScripts($data);?>