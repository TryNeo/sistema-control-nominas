<?php 
    const server_url = "http://localhost/sistema-control-nominas/";
    const server_url_image = "http://localhost/sistema-control-nominas/assets/images/";
    const regex_string = '/^[a-zA-ZáéíóñÁÉÍÓÚÑ, ]+$/';
    const regex_email = '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/';
    const regex_numbers = '/^[0-9]+$/';
    const regex_username = '/^[a-z0-9_-]{3,16}$/';
    const regex_password = '/^[a-zA-Z0-9_-]{4,18}$/';
    const regex_fechas = '/^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])\2(\d{4})$/';
    const regex_cedula =  '/^[0-9]{0,10}$/';
    
    const libs = "libraries/";
    const views = "views/";
    const company = "Sistema Control Nominas";
    date_default_timezone_set("America/Guayaquil");
