<?php 
    require_once "./config/app.php";
    require_once "./controllers/viewsControllers.php";

    $template = new viewsControllers();
    $template->get_template_controller();
?>
