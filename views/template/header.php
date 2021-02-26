<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $data["page_title"]?></title>
    <link rel="stylesheet" href="<?php echo server_url; ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?php echo server_url; ?>assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo server_url; ?>assets/libs/css/style.css">
    <link rel="stylesheet" href="<?php echo server_url; ?>assets/libs/boostrap-select/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="<?php echo server_url; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo server_url; ?>assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="icon" type="image/png" href="<?php echo server_url; ?>assets/images/nomina.png" sizes="16x16" />
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css"/>
    <style>
        html,
        body {
            height: 100%;
        }

        .new-style {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 66px;
            padding-bottom: 40px;
        }
    </style>
</head>
<body>
<div class="dashboard-main-wrapper">
    <div class="dashboard-header">
                <nav class="navbar navbar-expand-lg bg-white fixed-top">
                    <a class="navbar-brand" href="../index.html">W@SECURITY</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto navbar-right-top">
                            <li class="nav-item dropdown nav-user">
                                <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo server_url_image.$_SESSION['user_data']['foto']; ?>" alt="" class="user-avatar-md rounded-circle"></a>
                                <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                    <div class="nav-user-info">
                                        <h5 class="mb-0 text-white nav-user-name">
                                            <span class="status"></span><span class="ml-2">
                                                <?= $_SESSION['user_data']['nombre'] ?> <?= $_SESSION['user_data']['apellido'] ?>
                                            </span>
                                        </h5>
                                        <span class="status"></span><span class="ml-2"><?= $_SESSION['user_data']['nombre_rol'] ?></span><br>
                                        <span class="status"></span><span class="ml-2">
                                        
                                        <?php if($_SESSION['user_data']['estado'] == 1){?>
                                            <i class="far fa-check-circle"></i> Activo
                                        <?php }else{?>
                                            <i class="far fa-warning-circle"></i>Inactivo
                                        <?php }?>
                                        </span>
                                    </div>
                                    <a class="dropdown-item" href="<?php echo server_url ?>logout"><i class="fas fa-power-off mr-2"></i>Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
    </div>
    <?php require_once("./views/template/navbar.php")?>