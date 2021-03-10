<?php  
getHeader($data);
?>
<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form-group">
                    <label>Buscardor de empleado:</label>
                    <div class="input-group">
                        <select class="form-control select2" style="width:100%;" id="SearchEmpl">
                        </select>
                    </div>
                </div>
            </div>
        </div>
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
<?php 
getScripts($data);?>