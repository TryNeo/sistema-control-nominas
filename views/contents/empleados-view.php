<div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header" id="top">
                    <h2 class="pageheader-title text-center">Listado de Empleados</h2>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <button data-toggle="modal" data-target="#modalForm" href="#" class="btn btn-outline-secondary"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Empleado</button>        
                <div class="modal fade" id="modalForm" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Registro Empleados</h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="statusMsg"></p>
                                <form action="" method="POST" data-form="save" class="formAjax">
                                    <div class="form-group">
                                        <label for="inputName">Name</label>
                                        <input type="text" class="form-control" id="inputName" placeholder="Enter your name"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail">Email</label>
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Enter your email"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputMessage">Message</label>
                                        <textarea class="form-control" id="inputMessage" placeholder="Enter your message"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR<div class="ripple-container"><div class="ripple-decorator ripple-on ripple-out" style="left: 65.8594px; top: 14px; background-color: rgb(255, 255, 255); transform: scale(10.8691);"></div></div></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
