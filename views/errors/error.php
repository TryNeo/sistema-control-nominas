<?php getHeaderError($data); ?>
        <div class="bg-light text-center">
            <div class="container">
                <div class="row">
                    <div class="offset-xl-2 col-xl-8 offset-lg-2 col-lg-8 col-md-12 col-sm-12 col-12">
                        <div class="error-section">
                        <img src="https://colorlib.com/polygon/concept/assets/images/error-img.png" alt="" class="img-fluid">
                            <div class="error-section-content">
                            <h1 class="display-3">Pagina no encontrada</h1>
                            <p>La pagina a la que intenta acceder  <strong><?php echo $_GET["url"] ?></strong> no existe , compruebe que la url haya sido escrita correctamente</p>
                            <a href="<?php  echo server_url; ?>" class="btn btn-secondary btn-lg">Regresar a la pagina principal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white p-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-dark text-center">
                        Copyright © 2021 josue. All rights reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php getScriptsError($data); ?>
