<?php 
    require_once ("./config/app.php");
    require_once ("./helpers/helpers.php");
    
    $url = !empty($_GET['url']) ? $_GET['url'] : 'dashboard/dashboard';
    $array_url = explode("/",$url);
    $controller = $array_url[0];
    $method =  $array_url[0];
    $params = "";
    if  (!empty($array_url[1])){
        if ( $array_url[0] != ""){
            $method = $array_url[1];
        }
    }
    if  (!empty($array_url[2])){
        if ($array_url[2] !=""){
            for ($i=2; $i < count($array_url); $i++){
                $params .= $array_url[$i].',';
            }
            $params = trim($params,",");

        }
    }

    require_once("./libraries/core/autoload.php");
    require_once("./libraries/core/load.php");

    
?>
