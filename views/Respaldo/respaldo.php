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
        </div>
        <hr>
        <div class="row">
                <a href="#" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50">
                      <i class="fas fa-exclamation-triangle"></i>
                    </span>
                    <span class="text">inactivo</span>
                </a>
            <button type="button" id="backupbd">Realizar copia de seguridad</button>
        </div>
    </div>
</div>
<?php getScripts($data);?>