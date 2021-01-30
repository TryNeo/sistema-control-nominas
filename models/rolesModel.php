<?php
    require_once("./libraries/core/mysql.php");
    class rolesModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }

        public function selectRoles(){
            $sql = "SELECT id_rol,nombre,descripcion,estado FROM roles";
            $request = $this->select_sql_all($sql);
            return $request;
        }
    }

?>