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


        public function getEstadoPediente(){
            $query = "SELECT count(estado_nomina) as pendiente FROM nominas WHERE estado_nomina = 1 and estado !=0";
            $request = $this->select_sql_all($query);
            return $request;
        }

        public function getEstadoAceptado(){
            $query = "SELECT count(estado_nomina) as aceptado FROM nominas WHERE estado_nomina = 2 and estado !=0";
            $request = $this->select_sql_all($query);
            return $request;
        }

        public function getEstadoRechazado(){
            $query = "SELECT count(estado_nomina) as rechazado FROM nominas WHERE estado_nomina = 3 and estado !=0";
            $request = $this->select_sql_all($query);
            return $request;
        }
    }

?>