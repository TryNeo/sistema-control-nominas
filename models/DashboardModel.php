<?php
    require_once("./libraries/core/mysql.php");
    class DashboardModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }

        public function getTotalEmpleado(){
            $query = "SELECT * FROM empleados WHERE estado !=0";
            $request_query = $this->select_count($query);
            return $request_query;
        }
        
        public function getTotalNominas(){
            $query = "SELECT * FROM nominas WHERE estado !=0";
            $request_query = $this->select_count($query);
            return $request_query;
        }
    }

?>