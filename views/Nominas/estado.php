<?php getHeader($data); 
    getModal('modals_nominas_view',$data);

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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table tableEstado table-striped  first display responsive" cellspacing="0"  style="width:100%">
                            <thead>
                                <th>ID</th>
                                <th>Nomina</th>
                                <th>Periodo de inicio</th>
                                <th>Periodo de fin</th>
                                <th>Estado nomina</th>
                                <th>total</th>
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
getScripts($data);