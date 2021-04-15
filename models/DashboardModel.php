<?php
    require_once("./libraries/core/mysql.php");
    class DashboardModel extends Mysql{
        public $int_id_empleado;
        public $str_day_now;
        public $str_day_old;
        
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

        public function getTotalUsuarios(){
            $query = "SELECT * FROM usuarios WHERE estado !=0";
            $request_query = $this->select_count($query);
            return $request_query;
        }

        public function getTotalGeneral(){
            $query = "SELECT sum(nominas.total) as total FROM nominas WHERE estado !=0";
            $request = $this->select_sql_all($query);
            return $request;
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

        public function getNominaTotal(){
            $query = "SELECT nombre_nomina,total FROM nominas WHERE estado !=0";
            $request = $this->select_sql_all($query);
            return $request;
        }

        public function getEmpleadosNominasTotal(){
            $query = "SELECT empl.id_empleado,empl.nombre,empl.apellido,SUM(det.valor_total) as total from empleados as empl 
            INNER JOIN detalle_nomina as det ON det.id_empleado = empl.id_empleado and empl.estado!=0 group by empl.id_empleado";
            $request = $this->select_sql_all($query);
            return $request;
        }

        public function getEmpleadosNominasGeneral(int $int_id_empleado){
            $this->int_id_empleado = $int_id_empleado;
            $query = "SELECT nom.nombre_nomina,det.valor_total from empleados as empl 
            inner join detalle_nomina as det on det.id_empleado = empl.id_empleado 
            inner join nominas as nom ON nom.id_nomina = det.id_nomina
            WHERE det.id_empleado = $this->int_id_empleado and empl.estado!=0";
            $request = $this->select_sql_all($query);
            return $request;
        }


        public function getEmpleadosRecientes(){
            $this->str_day_now = date('Y-m-d');
            $this->str_day_old = date('Y-m-d',strtotime(date('Y-m-d').'- 1 days'));
            $query = "SELECT empl.nombre,empl.sueldo,puest.nombre_puesto FROM 
            empleados as empl INNER JOIN puestos as puest ON puest.id_puesto = empl.id_puesto
            WHERE empl.estado !=0 and DATE_FORMAT(empl.fecha_crea,'%Y-%m-%d') 
            in('$this->str_day_old','$this->str_day_now') ORDER BY empl.id_empleado DESC LIMIT 5;";
            $request = $this->select_sql_all($query);
            return $request;
        }

        public function getNominasRecientes(){
            $this->str_day_now = date('Y-m-d');
            $this->str_day_old = date('Y-m-d',strtotime(date('Y-m-d').'- 2 days'));
            $query = "SELECT nom.nombre_nomina,nom.total,nom.estado_nomina FROM 
            nominas as nom WHERE nom.estado !=0 and DATE_FORMAT(nom.fecha_crea,'%Y-%m-%d') 
            in('$this->str_day_old','$this->str_day_now') ORDER BY nom.id_nomina DESC LIMIT 5;";
            $request = $this->select_sql_all($query);
            return $request;
        }

    }

?>