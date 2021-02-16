<?php
    spl_autoload_register(function ($class) {
        if (file_exists(libs.'core/'.$class.'.php')){
            require_once(libs.'core/'.$class.'.php');
        }    
    });
?>