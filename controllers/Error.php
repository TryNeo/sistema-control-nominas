<?php
    require_once ("./libraries/core/controllers.php");

    class Errors extends Controllers{
        public function __construct(){

            parent::__construct();
        }

        public function notFound(){
            $data["page_title"] = "Error | 404";
            $this->views->getView($this,"error",$data);
        }

    }

    $notFound = new Errors();
    $notFound->notFound();
?>