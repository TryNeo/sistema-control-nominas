<?php
    require_once ("./libraries/core/controllers.php");

    class Roles extends Controllers{
        public function __construct(){

            parent::__construct();
        }

        public function roles(){
            $data["page_id"] = 2;
            $data["tag_pag"] = "Roles";
            $data["page_title"] = "Roles | Inicio";
            $data["page_name"] = "Listado de Roles";
            $this->views->getView($this,"roles",$data);

        }

        public function getRoles(){
            $data = $this->model->selectRoles();
            for ($i=0; $i < count($data); $i++) { 
               if ($data[$i]['estado'] == 1){
                   $data[$i]['estado']= "<span class='label label-success'>Activo</span>";
               }else{
                    $data[$i]['estado']="<span class='label label-danger'>Inactivo</span>";
               }
               $data[$i]['opciones'] = '
               <div class="text-center">
                <button type="button" class="btn btn-secondary btn-circle btn-permiso" title="permiso" rl="'.$data[$i]['id_rol'].'"><i class="fa fa-key"></i></button>
                <button type="button" class="btn btn-primary btn-circle btn-editar-rol" title="editar" rl="'.$data[$i]['id_rol'].'"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-danger btn-circle btn-eliminar-rol" title="eliminar" rl="'.$data[$i]['id_rol'].'"><i class="far fa-thumbs-down"></i></button></div>';
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setRol(){
            $rolInput = strclean($_POST["rolInput"]);
            $descriInput = strclean($_POST["descriInput"]);
            $estadoInput = intval($_POST["estadoInput"]);
            $request_rol = $this->model->insertRol($rolInput,$descriInput,$estadoInput);

            if ($request_rol > 0){
                $data = array('status' => true, 'msg' => 'datos guardados correctamente');
            }else if ($request_rol == 'exist'){
                $data = array('status' => false,'msg' => 'Error el rol ya existe');
            }else{
                $data = array('status' => false,'msg' => 'Hubo un error no se pudo almacendar los datos');

            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }
    }


?>