<?php
    require_once ("./libraries/core/controllers.php");

    class Logout extends Controllers{
        public function __construct(){
            session_start();
            session_unset();
            session_destroy();
            header('location:'.server_url.'login');
        }

      

    }

