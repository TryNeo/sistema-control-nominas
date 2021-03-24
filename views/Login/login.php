<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $data["page_title"];?></title>
        <link rel="stylesheet" href="<?php echo server_url; ?>assets/vendor/bootstrap/css/bootstrap.min.css">
        <link href="<?php echo server_url; ?>assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo server_url; ?>assets/libs/css/style.css">
        <link rel="stylesheet" href="<?php echo server_url; ?>assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
        <link rel="icon" type="image/png" href="<?php echo server_url; ?>assets/images/nomina-icon.png" sizes="16x16" />
        <style>
            html,
            body {
                height: 100%;
            }

            body {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-align: center;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
            }
            </style>
    </head>
    <body>
        <div class="splash-container new-style">
            <div class="card ">
                <div class="card-header text-center"><a href="<?php echo server_url?>/login"><img class="logo-img" src="<?php echo server_url; ?>assets/images/wosecurity.png" alt="logo" width="200"></a><span class="splash-description"><strong>W@SECURITY</strong></span></div>
                <div class="card-body">
                    <form name="formLogin" id="formLogin" action="">
                        <div class="form-group">
                            <input class="form-control form-control-lg" id="username" name="username" type="text" placeholder="ingrese su usuario" autocomplete="off">
                        </div>
                        <div class="form-group input-group">
                            <input class="form-control" id="password" name="password" type="password" placeholder="ingrese su contraseña">
                            <span class="input-group-btn">
                                <button id="show_password" class="btn btn-dark btn-lg" type="button" onclick="mostrarPassword()"> <span class="fa fa-eye-slash icon"></span> </button>
                            </span>
                        </div>
                        <button type="submit" class="btn btn-dark btn-lg btn-block"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</button>
                    </form>
                </div>
                <div class="card-footer bg-white p-0  ">
                    <div class="text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a class="btn btn-info btn-circle"href="#" class="footer-link">Facebook <i class="fab fa-facebook"></i></a></div>
                        <div class="card-footer-item card-footer-item-bordered">
                            <a class="btn btn-danger btn-circle" href="#">Instagram <i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo server_url; ?>assets/vendor/jquery/jquery-3.3.1.min.js"></script>
        <script src="<?php echo server_url; ?>assets/js/functions_login.js"></script>
        <script src="<?php echo server_url; ?>assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_principales.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </body>
</html>