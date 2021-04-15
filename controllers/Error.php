<?php
    require_once ("./libraries/core/controllers.php");

    class errors extends Controllers{
        public function __construct(){
            parent::__construct();
        }

        public function notFound(){
            $data["page_title"] = "Error | 404";
            $error = "error404";

            if (empty($_SESSION['permisos_modulo']['r'])) {
                $data["page_title"] = "Error | 403";
                $error = "error403";
            }
            $this->views->getView($this,$error,$data);
        }

    }

    $notFound = new errors();
    $notFound->notFound();
