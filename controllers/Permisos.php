<?php
    require_once ("./libraries/core/controllers.php");

    class Permisos extends Controllers{
        public function __construct(){
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(3);

            parent::__construct();
        }

        public function getPermisosRol(int $idRol){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            }else{
                $idRol = intval($idRol);
                if ($idRol > 0){
                    $arrModulos  = $this->model->selectModulos();
                    $arrPermisosRol = $this->model->selectPermisoRol($idRol);
                    $arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
                    $arrPermisoRol = array('id_rol' => $idRol);
    
                    if(empty($arrPermisosRol)){
                        for ($i = 0; $i < count($arrModulos);$i++){
                            $arrModulos[$i]['permisos'] = $arrPermisos;
                        }
                    }else{
                        for ($i = 0; $i < count($arrModulos);$i++){
                            $arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
                            if (isset($arrPermisosRol[$i])) {
                                $arrPermisos = array('r' => $arrPermisosRol[$i]['r'],
                                                    'w' => $arrPermisosRol[$i]['w'],
                                                    'u' => $arrPermisosRol[$i]['u'],
                                                    'd' => $arrPermisosRol[$i]['d'],
                                                    );
                            }
                            $arrModulos[$i]['permisos'] = $arrPermisos;
                        }
                    }
                    $arrPermisoRol['modulos'] = $arrModulos;
                    $html = getModal("modals_permisos",$arrPermisoRol);
                    die();
                }
            }
        }


        public function setPermisos()
        {   
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if ($_POST) {
                    $intIdRol = intval($_POST['id_rol']);
                    $modulos = $_POST['modulos'];
                    $this->model->deletePermisos($intIdRol);
                    foreach ($modulos as $modulo) {
                        $id_modulo = $modulo['id_modulo'];
    
                        $r = empty($modulo['r']) ? 0 : 1;
                        $w = empty($modulo['w']) ? 0 : 1;
                        $u = empty($modulo['u']) ? 0 : 1;
                        $d = empty($modulo['d']) ? 0 : 1;
    
                        $requestPermiso = $this->model->insertPermisos($intIdRol,$id_modulo,$r,$w,$u,$d);
                    }
                    if ($requestPermiso > 0){
                        $data = array('status' => true, 'msg' => 'Permisos asignados correctamente');
                    }else{
                        $data =  array('status' => false, 'msg' => 'No es posible asignar los permisos');
                    }
                }else{
                    $data =  array('status' => false, 'msg' => 'Error Hubo problemas');
    
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }
    }


?>