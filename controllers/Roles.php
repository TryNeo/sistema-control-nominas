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
                <button  class="btn btn-primary btn-circle btnEditarRol" title="editar" rl="'.$data[$i]['id_rol'].'"><i class="fa fa-edit"></i></button>
                <button  class="btn btn-danger btn-circle btnEliminarRol" title="eliminar" rl="'.$data[$i]['id_rol'].'"><i class="far fa-thumbs-down"></i></button></div>';
            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getRol(int $id_rol){
            $intRol  = Intval(strclean($id_rol));
            if ($intRol > 0){
                $data = $this->model->selectRol($intRol);
                if (empty($data)){
                    $data_response = array('status' => false,'msg'=> 'Datos no encontrados');
                }else{
                    $data_response = array('status' => true,'msg'=> $data);
                }
                echo json_encode($data_response,JSON_UNESCAPED_UNICODE);
            }die();
        }


        public function setRol(){
            $intRol = Intval(strclean($_POST['id_rol']));
            $rolInput = strclean($_POST["rolInput"]);
            $descriInput = strclean($_POST["descriInput"]);
            $estadoInput = intval($_POST["estadoInput"]);

            if ($intRol == 0){
                $request_rol = $this->model->insertRol($rolInput,$descriInput,$estadoInput);
                $option = 1;
            }else{
                $request_rol = $this->model->updateRol($intRol,$rolInput,$descriInput,$estadoInput);
                $option = 2;
            }
            
            if ($request_rol > 0){

                if ($option == 1){
                    $data = array('status' => true, 'msg' => 'datos guardados correctamente');
                }else{
                    $data = array('status' => true, 'msg' => 'datos actualizados correctamente');
                }
           
            }else if ($request_rol == 'exist'){
                $data = array('status' => false,'msg' => 'Error el rol ya existe');
           
            }else{
                $data = array('status' => false,'msg' => 'Hubo un error no se pudo almacendar los datos');

            }
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function delRol(){
            if ($_POST){
                $intRol = intval($_POST["id_rol"]);
                $request_del = $this->model->deleteRol($intRol);
                if($request_del == "ok"){
                    $data = array("status" => true, "msg" => "Se ha eliminado el rol");
                }else if ($request_del == "exist"){
                    $data = array("status" => false, "msg" => "No es posisible eliminar rol asociado a usuarios");
                }else{
                    $data = array("status" => false, "msg" => "Error al eliminar rol");
                }
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    
    }
?>