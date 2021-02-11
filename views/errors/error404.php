<?php getHeaderError($data); ?>
<body>
    <div class="scene">
    <div class="overlay"></div>
    <div class="overlay"></div>
    <div class="overlay"></div>
    <div class="overlay"></div>
    <span class="bg-403">404</span>
    <div class="text">
        <span class="hero-text"></span>
        <span class="msg">Pagina no encontrada </span>
        <span class="support">
        <span>La pagina a la que intenta acceder <strong><?php echo $_GET["url"] ?></strong> no existe , compruebe que la url haya sido escrita correctamente</p></span>
        <a href="<?php  echo server_url; ?>">Regresar a la pagina principal</a>
        </span>
    </div>
    <div class="lock"></div>
    </div>
</body>
</html>

