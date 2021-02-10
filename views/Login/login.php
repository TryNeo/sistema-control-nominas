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
                <div class="card-header text-center"><a href="#"><img class="logo-img" src="<?php echo server_url; ?>assets/images/wosecurity.png" alt="logo" width="200"></a><span class="splash-description"><strong>W@SECURITY</strong></span></div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <input class="form-control form-control-lg" id="username" type="text" placeholder="ingrese su username" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-lg" id="password" type="password" placeholder="ingrese su password">
                        </div>
                        <button type="submit" class="btn btn-dark btn-lg btn-block"><i class="fas fa-sign-in-alt"></i> Iniciar Sesion</button>
                    </form>
                </div>
                <div class="card-footer bg-white p-0  ">
                    <div class="text-center">
                        <div class="card-footer-item card-footer-item-bordered">
                            <a class="btn btn-info btn-circle"href="#" class="footer-link">Facebook <i class="fab fa-facebook"></i></a></div>
                        <div class="card-footer-item card-footer-item-bordered">
                            <a class="btn btn-danger btn-circle" href="#">Instgram <i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo server_url; ?>assets/vendor/jquery/jquery-3.3.1.min.js"></script>
        <script src="<?php echo server_url; ?>assets/js/functions_login.js"></script>
        <script src="<?php echo server_url; ?>assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    </body>
</html>