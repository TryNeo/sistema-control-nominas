<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo company;?></title>
    <?php include "./views/code/style.php";?>
</head>
<body>
    <div class="dashboard-main-wrapper">
        <?php include "./views/code/header.php"; ?>
        <?php include "./views/code/navbar.php"; ?>
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Empleados</h5>
                                    <h2 class="mb-0">0</h2>
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
                                    <h5 class="text-muted">Null</h5>
                                    <h2 class="mb-0">0</h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                    <i class="fa fa-user fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Null</h5>
                                    <h2 class="mb-0">0</h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-success-light mt-1">
                                    <i class="fa fa-user fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card border-3 border-top border-top-primary">
                            <div class="card-body">
                                <div class="d-inline-block">
                                    <h5 class="text-muted">Null</h5>
                                    <h2 class="mb-0">0</h2>
                                </div>
                                <div class="float-right icon-circle-medium  icon-box-lg  bg-danger-light mt-1">
                                    <i class="fa fa-user fa-fw fa-sm text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
    include "./views/code/scripts.php"; ?>
</body>
</html>