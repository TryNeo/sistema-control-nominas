<?php 

    function base_url(){
        return server_url;
    }

    function dep($data){
        $format = print_r('<pre>');
        $format .= print_r($data);
        $format .= print_r('</pre>');
        return $format;
    }

    function strclean($strstring){
        $string =  preg_replace('/\s\s+/', ' ', $strstring);
        $string = trim($strstring);
        $string = stripslashes($string);
        $string = str_ireplace("<script>","",$string);
        $string = str_ireplace("</script>","",$string);
        $string = str_ireplace("<script src>","",$string);
        $string = str_ireplace("<script type=>","",$string);
        $string = str_ireplace("SELECT * FROM","",$string);
        $string = str_ireplace("DELETE FROM","",$string);
        $string = str_ireplace("INSERT INTO","",$string);
        $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
        $string = str_ireplace("DROP TABLE","",$string);
        $string = str_ireplace("OR '1'='1'","",$string);
        $string = str_ireplace('OR "1"="1"',"",$string);
        $string = str_ireplace("IS NULL; --","",$string);
        $string = str_ireplace("is null; --","",$string);
        $string = str_ireplace("LIKE","",$string);
        $string = str_ireplace("--","",$string);
        $string = str_ireplace("^","",$string);
        $string = str_ireplace("[","",$string);
        $string = str_ireplace("]","",$string);
        $string = str_ireplace("==","",$string);
        return $string;
    }

    function passGenerator($length = 10){
        $pass = "";
        $longitudPass = $length;
        $cadena = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz1234567890";
        $longitudCadena = strlen($cadena);
        for ($i = 1 ; $i <= $longitudPass; $i++){
            $pos = rand(0,$longitudCadena);
            $pass .=substr($cadena,$pos);
        }
        return $pass;
    }

    function token(){
        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
        return $token;
    }

    function formartMoney($cantidad){
        $cantidad = number_format($cantidad,2,spd,spm);
        return $cantidad;
    }


    function getHeader($data=""){
        $view_header = "./views/template/header.php";
        return require_once($view_header);
    }

    function getScripts($data=""){
        $view_scripts = "./views/template/scripts.php";
        return require_once($view_scripts);
    }

    function getHeaderError($data=""){
        $view_header_error = "./views/template/header_error.php";
        return require_once($view_header_error);
    }

    function getScriptsError($data=""){
        $view_scripts_error = "./views/template/scripts_error.php";
        return require_once($view_scripts_error);
    }


    function getModal(string $nameModal,$data){
        $view_modal = "./views/template/modals/{$nameModal}.php";
        return require_once($view_modal);
    }

    function getPermisos(int $int_id_modulo){
        require_once("models/PermisosModel.php");
        $objPermisos = new PermisosModel();
        $id_rol = $_SESSION['user_data']['id_rol'];
        $dataPermisos = $objPermisos->permisoModel($id_rol);
        $permisos = '';
        $permisosModulo = '';
        if (count($dataPermisos) > 0) {
            $permisos = $dataPermisos;
            $permisosModulo = isset($dataPermisos[$int_id_modulo]) ? $dataPermisos[$int_id_modulo] : "";
        }
        $_SESSION["permisos"] = $permisos;
        $_SESSION["permisos_modulo"] = $permisosModulo;
    }

    function encrypt_decrypt($action, $string) {
        $output = false;
        
       $encrypt_method = "AES-256-CBC";
        $secret_key = 'secret key';
        $secret_iv = 'secret iv';
        
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        
       if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        }

        else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        
       return $output;
        }
?>