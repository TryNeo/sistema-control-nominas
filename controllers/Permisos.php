<?php
    require_once ("./libraries/core/controllers.php");

    class Permisos extends Controllers{
        public function __construct(){
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            
            parent::__construct();
        }

        public function getPermisosRol(int $idRol){
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
                        $arrPermisos = array('r' => $arrPermisosRol[$i]['r'],
                                             'w' => $arrPermisosRol[$i]['w'],
                                             'u' => $arrPermisosRol[$i]['u'],
                                             'd' => $arrPermisosRol[$i]['d'],
                                            );
                        if($arrModulos[$i]['id_modulo'] == $arrPermisosRol[$i]['id_modulo']){
                            $arrModulos[$i]['permisos'] = $arrPermisos;
                        }
                    }
                }
                $arrPermisoRol['modulos'] = $arrModulos;
                $html = getModal("modals_permisos",$arrPermisoRol);
            }
            die();
        }


        public function setPermisos()
        {
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
                    $data =  array('status' => true, 'msg' => 'No es posible asignar los permisos');
                }
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }


?>