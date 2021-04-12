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
        $string = str_ireplace("<>","",$string);
        $string = str_ireplace("<","",$string);
        $string = str_ireplace(";","",$string);
        $string = str_ireplace(">","",$string);
        $string = str_ireplace("</>","",$string);
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

    function validateCedula(string $cedula,$regex){
        if(empty(preg_matchall(array($cedula),$regex))){
            $cedula_array = array();
            for ($i=0; $i < strlen($cedula); $i++) { 
                array_push($cedula_array ,$cedula[$i]);
            }
            $cedula_array = array_map("xCel",$cedula_array);
            $ultimo_digito = array_splice($cedula_array,9,1);
            $cedula_array = array_splice($cedula_array,0,9);
            $array_impar = array_filter($cedula_array,"array_impar_return",ARRAY_FILTER_USE_BOTH);
            $array_par = array_map("sumPar",
                    array_filter($cedula_array,"array_par_return",ARRAY_FILTER_USE_BOTH)
                    );
            $totales = array_map("resPar",array_merge(
                    array_filter($array_par,"array_min_return",ARRAY_FILTER_USE_BOTH),
                    array_filter($array_par,"array_max_return",ARRAY_FILTER_USE_BOTH),
                    ));
            $totales_a = array_reduce($totales,"suma")+array_reduce($array_impar,"suma");
            $total = (intval(strval($totales_a)[0])+1)*10;
            if ($total == 10){
                $total = 0;
            }
    
            if(($total - $totales_a) == $ultimo_digito[0]){
                return true;
            }else{
                return false;
            }
        }else{
            echo var_dump(preg_matchall(array($cedula),$regex));
        }
    }

    function validateEmptyFields(array $arrayFields){
        if(empty($arrayFields)){
            return false;
        }else{
            $errorFields = array();
            $validateFields = array();
            foreach ($arrayFields as $key => $value) {
                $validate = ($value === '') ?  array_push($errorFields,$value) : array_push($validateFields,$value);
            }
            $error = (count($errorFields) > 0) ? false : true;
            return $error;
        }
    }

    function preg_matchall(array $array_strings,string $regexVal){
        $errors_array = array();
        foreach ($array_strings as $value) {
            if(preg_match($regexVal,$value)){}else{
                array_push(
                    $errors_array,
                    array("name"=>$value,"status"=>false)
                );
            }
        }
        return $errors_array;
    }

    function xCel($num){return ($num == "0") ? 0 : intval($num);}
    function array_impar_return($value,$key){ $impar = ($key%2==1) ? $value : ''; return $impar;}
    function array_par_return($value,$key){$par = ($key%2==0) ? $value : '';return $par;}
    function sumPar($value){ return $value+$value;}
    function suma($value,$value_2){$value+=$value_2;return $value;}
    function array_min_return($value,$key){$min = ($value <= 9) ? $value : ''; return $min;}
    function array_max_return($value,$key){$max = ($value >= 9) ? $value : ''; return $max;}
    function resPar($value){ return $value-9;}

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

