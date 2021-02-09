<?php
    require_once ("./libraries/core/controllers.php");

    class Usuarios extends Controllers{
        public function __construct(){

            parent::__construct();
        }

        public function usuarios($parems){
            $data["tag_pag"] = "Usuarios";
            $data["page_title"] = "Usuarios| Inicio";
            $data["page_name"] = "Listado de usuarios";
            $data['page'] = "usuario";
            $this->views->getView($this,"usuarios",$data);

        }


        public function getUsuarios(){
            $data = $this->model->selectUsuarios();
            for ($i=0; $i < count($data); $i++) { 
               if ($data[$i]['estado'] == 1){
                   $data[$i]['estado']= "<span class='label label-success'>Activo</span>";
               }else{
                    $data[$i]['estado']="<span class='label label-danger'>Inactivo</span>";
               }
               $data[$i]['opciones'] = '
               <div class="text-center">
                <button  class="btn btn-primary btn-circle btnEditarUsuario"  title="editar" us="'.$data[$i]['id_usuario'].'"><i class="fa fa-edit"></i></button>
                <button  class="btn btn-danger btn-circle btnEliminarUsuario"  title="eliminar" us="'.$data[$i]['id_usuario'].'"><i class="far fa-thumbs-down"></i></button></div>';
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        
        public function getUsuario(int $id_usuario){
            $intUsuario  = Intval(strclean($id_usuario));
            if ($intUsuario > 0){
                $data = $this->model->selectUsuario($intUsuario);
                if (empty($data)){
                    $data_response = array('status' => false,'msg'=> 'Datos no encontrados');
                }else{
                    $data_response = array('status' => true,'msg'=> $data);
                }
                echo json_encode($data_response,JSON_UNESCAPED_UNICODE);
            }die();
        }

        public function setUsuario(){

            if ($_POST) {
                $int_id_usuario = intval($_POST['id_usuario']);

                $str_nombre = ucwords(strclean($_POST['nombre']));
                $str_apellido = ucwords(strclean($_POST['apellido']));
                $str_usuario = strclean($_POST['usuario']);
                $str_email = strtolower(strclean($_POST['email']));
                $int_id_rol = intval(strclean($_POST['id_rol']));
                $int_estado = intval(strclean($_POST['estadoInput']));

                if($int_id_usuario == 0){
                    $option = 1;
                    $str_password = hash("SHA256",$_POST['password']);
                    $request_user = $this->model->insertUsuario($str_nombre,
                                                            $str_apellido,
                                                            $str_usuario,
                                                            $str_email,
                                                            $int_id_rol,
                                                            $str_password,
                                                            $int_estado);
                }else{
                    $option = 2;
                    $str_password = hash("SHA256",$_POST['password']);
                    $request_user = $this->model->updateUsuario($int_id_usuario,
                                                                $str_nombre,
                                                                $str_apellido,
                                                                $str_usuario,
                                                                $str_email,
                                                                $int_id_rol,
                                                                $str_password,
                                                                $int_estado);
                }

                if ($request_user > 0) {

                    if ($option == 1){
                        $data = array('status' => true, 'msg' => 'datos guardados correctamente');

                    }else{
                        $data = array('status' => true, 'msg' => 'datos actualizados correctamente');
                    }

                }else if ($request_user == 'exist'){
                    $data = array('status' => false, 'msg' => 'Error datos ya existentes');
                }else{
                    $data = array('status' => false, 'msg' => 'No es posible almacenar los datos');
                }
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            }
            die();

        }

    }


?>