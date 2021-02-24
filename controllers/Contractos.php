<?php
    require_once ("./libraries/core/controllers.php");

    class Contractos extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
            if (empty($_SESSION['login'])) {
                header('location:'.server_url.'login');
            }else{
                if(time()-$_SESSION["login_time_stamp"] >1800)   
                { 
                    session_unset(); 
                    session_destroy(); 
                    header('location:'.server_url.'logout');
                } 
            }
            getPermisos(6);
        }

        public function contractos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
            }
            $data["page_id"] = 6;
            $data["tag_pag"] = "Contractos";
            $data["page_title"] = "Contractos | Inicio";
            $data["page_name"] = "Listado de contractos";
            $data['page'] = "contractos";
            $this->views->getView($this,"contractos",$data);
        }

        public function getContractos(){
            if (empty($_SESSION['permisos_modulo']['r']) ) {
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error no tiene permisos");
            }else{
                $data = $this->model->selectContractos();
                for ($i=0; $i < count($data); $i++) {
                    $btnEditarContracto = '';
                    $btnEliminarContracto = '';
                    if ($data[$i]['estado'] == 1){
                        $data[$i]['estado']= '<span  class="btn btn-success btn-icon-split btn-sm"><i class="icon fas fa-check-circle "></i><span class="label text-padding text-white-50">&nbsp;&nbsp;Activo</span></span>';
                    }else{
                        $data[$i]['estado']='<span  class="btn btn-danger btn-icon-split btn-sm"><i class="icon fas fa-ban "></i><span class="label text-padding text-white-50">Inactivo</span></span>';
                    }

                    if ($_SESSION['permisos_modulo']['u']) {
                        $btnEditarContracto = '<button  class="btn btn-primary btn-circle btnEditarContracto" title="editar" cont="'.$data[$i]['id_contracto'].'"><i class="fa fa-edit"></i></button>';
                    }

                    if ($_SESSION['permisos_modulo']['d']) {
                        $btnEliminarContracto = '<button  class="btn btn-danger btn-circle btnEliminarRol" title="eliminar" cont="'.$data[$i]['id_contracto'].'"><i class="far fa-thumbs-down"></i></button>';
                    }

                    $data[$i]['opciones'] = '<div class="text-center">'.$btnEditarContracto.' '.$btnEliminarContracto.'</div>';
                }
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setContracto(){
            if ($_POST) {
                $intContracto = Intval(strclean($_POST['id_contracto']));
                $contractoInput = strclean($_POST["nombre_contracto"]);
                $descriInput = strclean($_POST["descripcion"]);
                $estadoInput = intval($_POST["estadoInput"]);

                if ($intContracto == 0){
                    $request_contracto = $this->model->insertContracto($contractoInput,$descriInput,$estadoInput);
                    $option = 1;
                }else{
                
                }

                if ($request_contracto > 0){ 
                    if (empty($_SESSION['permisos_modulo']['w'])){
                        header('location:'.server_url.'Errors');
                        $data= array("status" => false, "msg" => "Error no tiene permisos");
                    }else{
                        if ($option == 1){
                            $data = array('status' => true, 'msg' => 'datos guardados correctamente');
                        }
                    }
                }else if ($request_contracto == 'exist'){
                        $data = array('status' => false,'msg' => 'Error el contracto ya existe');
                    
                }else{
                        $data = array('status' => false,'msg' => 'Hubo un error no se pudo almacendar los datos');
                    }

            }else{
                header('location:'.server_url.'Errors');
                $data = array("status" => false, "msg" => "Error Hubo problemas");
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

    }


?>