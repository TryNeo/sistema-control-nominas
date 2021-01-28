<?php
    function sql_autoload_register($class){
        if (file_exists(libs.'core/'.$class.'.php')){
            require_once(libs.'core/'.$class.'.php');
         }
    }
?>