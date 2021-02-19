<?php
    require_once ("./libraries/core/controllers.php");

    class Roles extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(3);


        }

        public function roles(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 2;
            $data["tag_pag"] = "Roles";
            $data["page_title"] = "Roles | Inicio";
            $data["page_name"] = "Listado de Roles";
            $data['page'] = "roles";
            $this->views->getView($this,"roles",$data);

        }

        public function getRoles(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectRoles();
                for ($i=0; $i < count($data); $i++) { 
                    $btnPermisoRol = '';
                    $btnEditarRol = '';
                    $btnEliminarRol='';
    
                   if ($data[$i]['estado'] == 1){
                       $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                   }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                   }
                   
                    if ($_SESSION['permisos_modulo']['r']) {
                        $btnPermisoRol = '<button type="button" class="btn btn-secondary btn-circle btnPermiso" title="permiso" rl="'.$data[$i]['id_rol'].'"><i class="fa fa-key"></i></button>';
                    }
    
                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnEditarRol = '<button  class="btn btn-primary btn-circle btnEditarRol" title="editar" rl="'.$data[$i]['id_rol'].'"><i class="fa fa-edit"></i></button>';
                    }
    
                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarRol = '<button  class="btn btn-danger btn-circle btnEliminarRol" title="eliminar" rl="'.$data[$i]['id_rol'].'"><i class="far fa-thumbs-down"></i></button>';
                    }
    
                    $data[$i]['opciones'] = '<div class="text-center">'.$btnPermisoRol.' '.$btnEditarRol.' '.$btnEliminarRol.'</div>';
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getRol(int $id_rol){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $intRol  = Intval(strclean($id_rol));
                if ($intRol > 0){
                    $data = $this->model->selectRol($intRol);
                    if (empty($data)){
                        $data_response = array('status' => false,'msg'=> 'Datos no encontrados');
                    }else{
                        $data_response = array('status' => true,'msg'=> $data);
                    }
                }
            }
            echo json_encode($data_response,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function setRol(){
            if ($_POST) {
                $intRol = Intval(strclean($_POST['id_rol']));
                $rolInput = strclean($_POST["nombre_rol"]);
                $descriInput = strclean($_POST["descripcion"]);
                $estadoInput = intval($_POST["estadoInput"]);
    
                if(empty($intRol)||empty($rolInput)||empty($descriInput)||empty($estadoInput)){
                    $data = array('status' => false,'msg' => 'Hubo un error no se pudo almacendar los datos');
                }else{
                    if ($intRol == 0){
                        $request_rol = $this->model->insertRol($rolInput,$descriInput,$estadoInput);
                        $option = 1;
                    }else{
                        $request_rol = $this->model->updateRol($intRol,$rolInput,$descriInput,$estadoInput);
                        $option = 2;
                    }
                    
                    if ($request_rol > 0){
    
                        if (empty($_SESSION['permisos_modulo']['w'])){
                            header('location:'.server_url.'Errors');
                            $data= array("status" => false, "msg" => "Error no tiene permisos");
                        }else{
                            if ($option == 1){
                                $data = array('status' => true, 'msg' => 'datos guardados correctamente');
                            }
                        }

                        if (empty($_SESSION['permisos_modulo']['u'])) {
                            header('location:'.server_url.'Errors');
                            $data= array("status" => false, "msg" => "Error no tiene permisos");
                        }else{
                            if ($option == 2){
                                $data = array('status' => true, 'msg' => 'datos actualizados correctamente');
                            }
                        }
                
                    }else if ($request_rol == 'exist'){
                        $data = array('status' => false,'msg' => 'Error el rol ya existe');
                
                    }else{
                        $data = array('status' => false,'msg' => 'Hubo un error no se pudo almacendar los datos');
                    }
                }
            }else{
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error Hubo problemas");
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function delRol(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if ($_POST){
                    $intRol = intval($_POST["id"]);
                    $request_del = $this->model->deleteRol($intRol);
                    if($request_del == "ok"){
                        $data = array("status" => true, "msg" => "Se ha eliminado el rol");
                    }else if ($request_del == "exist"){
                        $data = array("status" => false, "msg" => "No es posisible eliminar rol asociado a usuarios");
                    }else{
                        $data = array("status" => false, "msg" => "Error al eliminar rol");
                    }
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }
    

        public function getSelectRoles()
        {   
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $html_options = "";
                $data = $this->model->selectRolesNoInactivos();
                if (count($data) > 0) {
                    for ($i=0; $i < count($data) ; $i++) { 
                        $html_options .='<option value="'.$data[$i]['id_rol'].'">'.$data[$i]['nombre_rol'].'</option>';
                    }
                }
                echo $html_options;                
                die();
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }
    }
?>