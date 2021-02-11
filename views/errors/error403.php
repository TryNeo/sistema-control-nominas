<?php getHeaderError($data); ?>
<body>
    <div class="scene">
    <div class="overlay"></div>
    <div class="overlay"></div>
    <div class="overlay"></div>
    <div class="overlay"></div>
    <span class="bg-403">403</span>
    <div class="text">
        <span class="hero-text"></span>
        <span class="msg">Pagina restringida </span>
        <span class="support">
            La pagina a la que intenta acceder , no le esta permitida su accesso </p>
        <a href="<?php  echo server_url; ?>">Regresar a la pagina principal</a>
        </span>
    </div>
    <div class="lock"></div>
    </div>
</body>
</html>

