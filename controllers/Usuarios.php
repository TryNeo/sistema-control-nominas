<?php
    require_once ("./libraries/core/controllers.php");

    class Usuarios extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            session_regenerate_id(true);
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }
            getPermisos(2);

        }

        public function usuarios(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }

            $data['page_id'] = 2;
            $data["tag_pag"] = "Usuarios";
            $data["page_title"] = "Usuarios| Inicio";
            $data["page_name"] = "Listado de usuarios";
            $data['page'] = "usuario";
            $this->views->getView($this,"usuarios",$data);

        }


        public function getUsuarios(){
            if (empty($_SESSION['permisos_modulo']['r'])) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectUsuarios();
                for ($i=0; $i < count($data); $i++) { 
                    $btnEditarUsuario = '';
                    $btnEliminarUsuario = '';
                
                if ($data[$i]['foto'] == 'avatar-2.jpg'){
                    $data[$i]['foto'] = '<div class="m-r-10"><img src="'.server_url_image.$data[$i]['foto'].'"  class="rounded" width="45"></div>';
                }else{
                    $data[$i]['foto'] = '<div class="m-r-10"><img src="'.server_url_image.$data[$i]['foto'].'"  class="rounded" width="45"></div>';
                }

                if ($data[$i]['estado'] == 1){
                    $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                }else{
                    $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                }

                
                if ($_SESSION['permisos_modulo']['u']) {
                    if(($_SESSION['id_usuario'] == 1 and $_SESSION['user_data']['id_rol'] == 1) ||
                    ($_SESSION['user_data']['id_rol'] == 1 and $data[$i]['id_rol'] != 1)){
                        $btnEditarUsuario = '<button  class="btn btn-primary btn-circle btnEditarUsuario"  title="editar" us="'.$data[$i]['id_usuario'].'"><i class="fa fa-edit"></i></button>';
                    }else{
                        $btnEditarUsuario = '<button  class="btn btn-primary btn-circle "  title="editar" disabled><i class="fa fa-edit"></i></button>';
                    }
                }

                if ($_SESSION['permisos_modulo']['d']) {
                    if(($_SESSION['id_usuario'] == 1 and $_SESSION['user_data']['id_rol'] == 1) ||
                    ($_SESSION['user_data']['id_rol'] == 1 and $data[$i]['id_rol'] != 1) and 
                    ($_SESSION['user_data']['id_usuario'] != $data[$i]['id_usuario'])){
                        $btnEliminarUsuario = '<button  class="btn btn-danger btn-circle btnEliminarUsuario"  title="eliminar" us="'.$data[$i]['id_usuario'].'"><i class="far fa-thumbs-down"></i></button>';
                    }else{
                        $btnEliminarUsuario = '<button  class="btn btn-danger btn-circle "  title="eliminar" disabled><i class="far fa-thumbs-down"></i></button>';
                    }
                }

                    $data[$i]['opciones'] = '<div class="text-center">'.$btnEditarUsuario.' '.$btnEliminarUsuario.'</div>';
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        
        public function getUsuario(int $id_usuario){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data_response = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $intUsuario  = Intval(strclean($id_usuario));
                if ($intUsuario > 0){
                    $data = $this->model->selectUsuario($intUsuario);
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

        public function setUsuario(){
                if ($_POST) {
                    $int_id_usuario = intval($_POST['id_usuario']);
                    $str_nombre = ucwords(strclean($_POST['nombre']));
                    $str_apellido = ucwords(strclean($_POST['apellido']));
                    $str_usuario = strclean($_POST['usuario']);
                    $str_email = strtolower(strclean($_POST['email']));
                    $int_id_rol = intval($_POST['id_rol']);
                    $int_estado = intval(strclean($_POST['estadoInput']));


                    $tipo = $_FILES['foto']['type'];
                    $tamagno = $_FILES['foto']['size'];
                    if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamagno < 2000000))) {
                        $data = array("status" => false, "msg" => ">Error. La extensión o el tamaño de los archivos no es correcta.
                        - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.");
                    }else{
                        $route_imagen = (isset($_FILES['foto']['name'])) ?$_FILES['foto']['name']:"";
                        $fecha = new DateTime();
                        $str_imagen = ($route_imagen!="")?$fecha->getTimestamp()."_".$_FILES['foto']['name']:"user-default.png";
                        $tmp_foto = $_FILES['foto']['tmp_name'];
                        if ($tmp_foto!=""){
                            move_uploaded_file($tmp_foto,"./assets/images/".$str_imagen);
                        }     
                    }
                    
                    if($int_id_usuario == 0){
                        $option = 1;
                        $str_password = hash("SHA256",$_POST['password']);
                        $request_user = $this->model->insertUsuario($str_nombre,
                                                                $str_apellido,
                                                                $str_imagen,
                                                                $str_usuario,
                                                                $str_email,
                                                                $int_id_rol,
                                                                $str_password,
                                                                $int_estado);
                    }else{
                        $request_image = $this->model->selectImage($int_id_usuario);
                        if (empty($_FILES['foto']['name'])){
                            $str_imagen = $request_image['foto'];
                        }else{
                            $tipo = $_FILES['foto']['type'];
                            $tamagno = $_FILES['foto']['size'];
                            if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamagno < 2000000))) {
                                $data = array("status" => false, "msg" => ">Error. La extensión o el tamaño de los archivos no es correcta.
                                - Se permiten archivos .gif, .jpg, .png. y de 200 kb como máximo.");
                            }else{
                                $route_imagen = (isset($_FILES['foto']['name'])) ?$_FILES['foto']['name']:"";
                                $fecha = new DateTime();
                                $str_imagen = ($route_imagen!="")?$fecha->getTimestamp()."_".$_FILES['foto']['name']:"user-default.png";
                                $tmp_foto = $_FILES['foto']['tmp_name'];
                                if ($tmp_foto!=""){
                                    unlink("./assets/images/".$request_image['foto']);
                                    move_uploaded_file($tmp_foto,"./assets/images/".$str_imagen);
                                }
                            }


                        }
                        $option = 2;
                        $str_password =  $_POST['password'];
                        $request_user = $this->model->updateUsuario($int_id_usuario,
                                                                    $str_nombre,
                                                                    $str_apellido,
                                                                    $str_imagen,
                                                                    $str_usuario,
                                                                    $str_email,
                                                                    $int_id_rol,
                                                                    $str_password,
                                                                    $int_estado);
                    }

                    if ($request_user > 0) {

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

                    }else if ($request_user == 'exist'){
                        $data = array('status' => false, 'msg' => 'Error datos ya existentes');
                    }else{
                        $data = array('status' => false, 'msg' => 'No es posible almacenar los datos');
                    }
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                die();

        }

        public function delUsuario(){
            if (empty($_SESSION['permisos_modulo']['d']) ) {
                header('location:'.server_url.'Errors');
                $data= array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                if ($_POST) {
                    $intUsuario = intval($_POST["id"]);
                    $request_del = $this->model->deleteUsuario($intUsuario);
                    if ($request_del == "ok") {
                        $data = array("status" => true, "msg" => "Se ha eliminado el usuario");
                    }else{
                        $data = array("status" => false, "msg" => "Error al eliminar el usuario");
                    }
                }else{
                    $data = array("status" => false, "msg" => "Error Hubo problemas");
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

    }


?>