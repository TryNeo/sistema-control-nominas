<?php
    require_once ("./libraries/core/controllers.php");

    class Dashboard extends Controllers{
        public function __construct(){

            parent::__construct();
        }

        public function dashboard($parems){
            $this->views->getView($this,"dashboard");
        }
    }


?>