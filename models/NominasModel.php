<?php
    require_once("./libraries/core/mysql.php");
    class NominasModel extends Mysql{
        public $int_id_nomina;
        public $int_id_empleado;
        public $int_id_detalle_nomina;
        public $int_meses_nomina;
        public $str_nombre_nomina;
        public $str_search_empleado;
        public $date_periodo_inicio;
        public $date_periodo_fin;
        public $int_estado_nomina;
        public $int_estado;
        public $int_total_pagar;
        public $float_valor_total;

        public function __construct(){
            parent::__construct();
        }

        public function selectNominasReporte(){
            $sql = "SELECT nom.id_nomina,
            nom.nombre_nomina,
            nom.periodo_inicio,
            nom.periodo_fin,
            nom.estado_nomina,
            nom.total
            FROM nominas as nom WHERE nom.estado !=0" ;
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function getTotalNominas(){
            $query = "SELECT * FROM nominas WHERE estado !=0";
            $request_query = $this->select_count($query);
            return $request_query;
        }

        public function getTotalGeneral(){
            $query = "SELECT sum(nominas.total) as total FROM nominas WHERE estado !=0";
            $request = $this->select_sql_all($query);
            return $request;
        }

        public function selectDetalleNomina(int $int_id_nomina){
            $this->int_id_nomina = $int_id_nomina;
            $sql = "SELECT nom.nombre_nomina,nom.periodo_inicio,nom.periodo_fin,nom.estado_nomina,nom.total
            FROM nominas as nom WHERE id_nomina = $this->int_id_nomina and nom.estado !=0" ;
            $request = $this->select_sql($sql);

            $sql_detalle = "SELECT empl.nombre,empl.apellido,puest.nombre_puesto,empl.sueldo,det.meses,det.valor_total FROM detalle_nomina as det
            INNER JOIN empleados as empl ON empl.id_empleado = det.id_empleado
            INNER JOIN puestos as puest ON puest.id_puesto = empl.id_puesto
            WHERE det.id_nomina = $this->int_id_nomina" ;
            $request_detalle = $this->select_sql_all($sql_detalle);

            return [$request,$request_detalle];
        }

        public function selectNominas(){
            $sql = "SELECT nom.id_nomina,
            nom.nombre_nomina,
            nom.periodo_inicio,
            nom.periodo_fin,
            nom.total,
            nom.estado_nomina,
            nom.estado
            FROM nominas as nom WHERE nom.estado !=0 and nom.estado_nomina !=3" ;
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectEstadoNominas(){
            $sql = "SELECT nom.id_nomina,
            nom.nombre_nomina,
            nom.periodo_inicio,
            nom.periodo_fin,
            nom.total,
            nom.estado_nomina
            FROM nominas as nom WHERE nom.estado !=0";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectNomina(int $int_id_nomina){
            $this->int_id_nomina = $int_id_nomina;
            $sql = "SELECT nom.id_nomina,
                    nom.nombre_nomina,
                    nom.periodo_inicio,
                    nom.periodo_fin,
                    nom.estado_nomina,
                    (SELECT SUM(valor_total) FROM detalle_nomina WHERE id_nomina = $this->int_id_nomina) as total 
                    FROM nominas as nom WHERE nom.id_nomina = $this->int_id_nomina";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function selectNominaTotal(int $int_id_nomina){
            $this->int_id_nomina = $int_id_nomina;
            $sql = "SELECT SUM(det.valor_total) as total FROM detalle_nomina as det
            WHERE det.id_nomina = $this->int_id_nomina";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function selectNominaEmpleado(string $str_search_empleado){
            $this->str_search_empleado = $str_search_empleado;
            $sql = "SELECT empl.id_empleado,empl.nombre,empl.apellido,empl.sueldo,puest.nombre_puesto 
            FROM empleados as empl
            INNER JOIN puestos as puest ON puest.id_puesto = empl.id_puesto
            WHERE nombre like '%".$this->str_search_empleado."%' or apellido like '%".$this->str_search_empleado."%' or
            puest.nombre_puesto like '%".$this->str_search_empleado."%' and  empl.estado!=0 LIMIT 20";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectNominaEmpleadoAll(int $id_nomina,int $id_empleado){
            $this->int_id_nomina = $id_nomina;
            $this->int_id_empleado = $id_empleado;
            $sql = "SELECT det.id_detalle_nomina,empl.nombre,empl.apellido,puest.nombre_puesto,empl.sueldo,det.meses,det.valor_total FROM detalle_nomina as det
            INNER JOIN empleados as empl ON det.id_empleado = empl.id_empleado
            INNER JOIN puestos as puest ON puest.id_puesto = empl.id_puesto
            WHERE det.id_nomina = $this->int_id_nomina and det.id_empleado = $this->int_id_empleado";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function selectSearchNominaEmpleado(int $id_empleado){
            $this->int_id_empleado = $id_empleado;
            $sql = "SELECT empl.id_empleado,empl.nombre,empl.apellido,empl.sueldo FROM empleados as empl WHERE empl.id_empleado = $this->int_id_empleado and estado!=0";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function selectEmpleadosNominas(int $id_nomina){
            $this->int_id_nomina = $id_nomina;
            $sql = "SELECT id_empleado FROM detalle_nomina WHERE id_nomina = $this->int_id_nomina";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectDetalleEmpleadosNominas(int $id_nomina){
            $this->int_id_nomina = $id_nomina;
            $sql = "SELECT empl.id_empleado
            FROM detalle_nomina as det
            INNER JOIN empleados as empl ON det.id_empleado = empl.id_empleado
            WHERE det.id_nomina = $this->int_id_nomina";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function insertNomina(string $str_nombre_nomina, string $date_periodo_inicio,
        string $date_periodo_fin ,int $int_estado_nomina,int $int_estado){
            $this->str_nombre_nomina = $str_nombre_nomina;
            $this->date_periodo_inicio = $date_periodo_inicio;
            $this->$date_periodo_fin = $date_periodo_fin;
            $this->$int_estado_nomina = $int_estado_nomina;
            $this->$int_estado = $int_estado;
            $sql_insert = "INSERT INTO nominas(nombre_nomina,periodo_inicio,periodo_fin,
            estado_nomina,estado,fecha_crea) values (?,?,?,?,?,now())";
            $data = array($this->str_nombre_nomina,$this->date_periodo_inicio,$this->$date_periodo_fin,$this->$int_estado_nomina,$this->$int_estado);
            $request_insert = $this->insert_sql($sql_insert,$data);
            $return = $request_insert;
            return $return;
        }

        public function insertDetalle(int $id_empleado,int $id_nomina){
            $this->int_id_empleado = $id_empleado;
            $this->int_id_nomina = $id_nomina;
            $sql = "SELECT * FROM detalle_nomina WHERE id_empleado = $this->int_id_empleado and id_nomina = $this->int_id_nomina";
            $request = $this->select_sql_all($sql);
            if (empty($request)) {
                $sql_insert = "INSERT INTO detalle_nomina(id_nomina,id_empleado) VALUES (?,?)";
                $data = array($this->int_id_nomina,$this->int_id_empleado);
                $request_insert = $this->insert_sql($sql_insert,$data);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function updateDetalle(int $int_id_nomina,int $int_id_empleado,string $str_nombre_nomina,int $estado_nomina,int $int_total_pagar){
            $this->int_id_nomina = $int_id_nomina;
            $this->int_id_empleado = $int_id_empleado;
            $this->str_nombre_nomina = $str_nombre_nomina;
            $this->int_estado_nomina = $estado_nomina;
            $this->int_total_pagar = $int_total_pagar;
            $sql_update_nomina = "UPDATE nominas SET nombre_nomina = ?, estado_nomina = ?,total = ?,fecha_modifica = now() WHERE id_nomina = $this->int_id_nomina";
            $data_nomina = array($this->str_nombre_nomina,$this->int_estado_nomina,$this->int_total_pagar);
            $request_update_nomina = $this->update_sql($sql_update_nomina,$data_nomina);
        }

        public function updateDetalleMesesTotal(string $id_detalle_nomina,int $int_meses_nomina,int $int_total_pagar){
            $this->int_id_detalle_nomina = $id_detalle_nomina;
            $this->int_meses_nomina = $int_meses_nomina;
            $this->int_total_pagar = $int_total_pagar;
            $sql_update = "UPDATE detalle_nomina SET meses = ? ,valor_total = ? WHERE id_detalle_nomina = $this->int_id_detalle_nomina";
            $data_total = array($this->int_meses_nomina,$this->int_total_pagar);
            $request_update_total =  $this->update_sql($sql_update,$data_total);
            if ($request_update_total ){
                $request_update_total = 'ok';
            }else{
                $request_update_total = 'error';
            }
            return $request_update_total;
        }


        public function updateNominaTotal(int $int_id_nomina, int $int_total_pagar){
            $this->int_id_nomina = $int_id_nomina;
            $this->int_total_pagar = $int_total_pagar;
            $sql_update = "UPDATE nominas SET total = ? ,fecha_modifica = now() WHERE id_nomina = $this->int_id_nomina";
            $data_total = array($this->int_total_pagar);
            $request_update_total =  $this->update_sql($sql_update,$data_total);
            if ($request_update_total ){
                $request_update_total = 'ok';
            }else{
                $request_update_total = 'error';
            }
            return $request_update_total;
        }
        
        public function updateEstadoNomina(int $int_id_nomina,int $int_estado_nomina){
            $this->int_id_nomina = $int_id_nomina;
            $this->int_estado_nomina = $int_estado_nomina;
            $sql = "SELECT * FROM nominas WHERE id_nomina = $this->int_id_nomina";
            $request = $this->select_sql_all($sql);
            if (empty($request)) {
                $request_update_estado_nomina = 'no';
            }else{
                $sql_update_estado_nomina = "UPDATE nominas SET estado_nomina = ?,fecha_modifica = now() WHERE id_nomina = $this->int_id_nomina";
                $data_nomina = array($this->int_estado_nomina);
                $request_update_estado_nomina =  $this->update_sql($sql_update_estado_nomina,$data_nomina);
                if ($request_update_estado_nomina){
                    $request_update_estado_nomina = $request_update_estado_nomina;
                }else{
                    $request_update_total = 'error';
                }
            }
            return $request_update_estado_nomina;
        }

        public function deleteDetalle(int $id_detalle_nomina){
            $this->int_id_detalle_nomina = $id_detalle_nomina;
            $sql_delete = "DELETE FROM detalle_nomina WHERE id_detalle_nomina = $this->int_id_detalle_nomina";
            $request_delete = $this->delete_sql($sql_delete);
            if ($request_delete){
                $request_delete = 'ok';
            }else{
                $request_delete = 'error';
            }
            return $request_delete;
        }

        public function deleteNomina(int $int_id_nomina){
            $this->int_id_nomina = $int_id_nomina;
            $sql = "UPDATE nominas set estado = ? , fecha_modifica = now() WHERE id_nomina = $this->int_id_nomina";
            $data = array(0);
            $request_delete = $this->update_sql($sql,$data);
            if ($request_delete){
                $request_delete = 'ok';
            }else{
                $request_delete = 'error';
            }
            return $request_delete;
        }

    }
?>