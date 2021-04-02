<?php getHeader($data);?>
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Empleados</h5>
                                    <h2 class="mb-0"><?php echo $data["total_empleados"]; ?></h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                    <i class="fa fa-users fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Nominas</h5>
                                    <h2 class="mb-0"><?php echo $data["total_nominas"]; ?></h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                    <i class="fa fa-id-badge fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Usuarios</h5>
                                    <h2 class="mb-0"><?php echo $data["total_usuarios"]; ?></h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                    <i class="fa fa-user fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Ingresos totales</h5>
                                    <h2 class="mb-0"><?php echo $data["total_general"]; ?></h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                    <i class="fa fa-money-bill-alt fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Nuevos empleados <i class="fas fa-plus-circle"></i></h5>
                            <div class="card-body">
                                <table class="table table-bordered table-hover first display responsive" cellspacing="0"  style="width:100%">
                                    <thead>
                                        <th>Nombre</th>
                                        <th>Sueldo</th>
                                        <th>Cargo</th>
                                    </thead>
                                    <tbody id="empleadosNow">
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-center">
                                <a href="<?php echo server_url; ?>empleados" class="btn-primary-link">Ver todos los empleados</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Nuevas Nominas <i class="fas fa-plus-circle"></i></h5>
                            <div class="card-body">
                                <table class="table table-bordered table-hover first display responsive" cellspacing="0"  style="width:100%">
                                    <thead>
                                        <th>Nomina</th>
                                        <th>Total</th>
                                        <th>Estado nomina</th>
                                    </thead>
                                    <tbody id="nominasNow">
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer text-center">
                                <a href="<?php echo server_url; ?>nominas" class="btn-primary-link">Ver todas las nominas</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Grafico | Empleados por nominas</h5>
                            <div class="card-body">
                                <figure class="highcharts-figure">
                                    <div id="empleadosGrahp"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Grafico | Totales por nominas</h5>
                            <div class="card-body">
                                <figure class="highcharts-figure">
                                    <div id="AgnoGrahp"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Grafico | Estado Nominas</h5>
                            <div class="card-body">
                                <figure class="highcharts-figure">
                                    <div id="estadoGrahp"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Grafico | Total de Nominas</h5>
                            <div class="card-body">
                            <figure class="highcharts-figure">
                                <div id="totalGrahp"></div>
                            </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php getScripts($data);?>