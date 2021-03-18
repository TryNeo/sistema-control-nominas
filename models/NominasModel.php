<?php
    require_once("./libraries/core/mysql.php");
    class NominasModel extends Mysql{
        public $int_id_nomina;
        public $int_id_empleado;
        public $int_id_detalle_nomina;
        public $int_meses_nomina;
        public $str_nombre_nomina;
        public $date_periodo_inicio;
        public $date_periodo_fin;
        public $int_estado_nomina;
        public $int_estado;
        public $int_total_pagar;
        public $float_valor_total;

        public function __construct(){
            parent::__construct();
        }

        public function selectNominas(){
            $sql = "SELECT nom.id_nomina,
            nom.nombre_nomina,
            nom.periodo_inicio,
            nom.periodo_fin,
            nom.total,
            nom.estado_nomina,
            nom.estado
            FROM nominas as nom WHERE nom.estado !=0" ;
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
                    nom.total
                    FROM nominas as nom WHERE nom.id_nomina = $this->int_id_nomina";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function selectNominaTotal(int $int_id_nomina,int $int_id_detalle_nomina){
            $this->int_id_nomina = $int_id_nomina;
            $this->int_id_detalle_nomina= $int_id_detalle_nomina;
            $sql = "SELECT det.valor_total,nom.total FROM detalle_nomina as det
            INNER JOIN nominas as nom ON nom.id_nomina = det.id_nomina
            WHERE det.id_nomina = $this->int_id_nomina";
            $request = $this->select_sql($sql);
            return $request;
        }

        public function selectNominaEmpleado(){
            $sql = "SELECT empl.id_empleado,empl.nombre,empl.apellido FROM empleados as empl WHERE estado!=0";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function selectNominaEmpleadoAll(int $id_nomina,int $id_empleado){
            $this->int_id_nomina = $id_nomina;
            $this->int_id_empleado = $id_empleado;
            $sql = "SELECT det.id_detalle_nomina,empl.nombre,puest.nombre_puesto,empl.sueldo,det.meses,det.valor_total FROM detalle_nomina as det
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
            $sql = "SELECT empl.id_empleado,empl.sueldo FROM detalle_nomina as det
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

        public function updateDetalle(int $int_id_nomina,int $int_id_empleado,string $str_nombre_nomina,
            int $int_meses_nomina,int $estado_nomina,float $valor_total,int $int_total_pagar){
            $this->int_id_nomina = $int_id_nomina;
            $this->int_id_empleado = $int_id_empleado;
            $this->str_nombre_nomina = $str_nombre_nomina;
            $this->int_meses_nomina = $int_meses_nomina;
            $this->int_estado_nomina = $estado_nomina;
            $this->float_valor_total = $valor_total;
            $this->int_total_pagar = $int_total_pagar;
            $sql_update_nomina = "UPDATE nominas SET nombre_nomina = ?, estado_nomina = ?,total = ?,fecha_modifica = now() WHERE id_nomina = $this->int_id_nomina";
            $data_nomina = array($this->str_nombre_nomina,$this->int_estado_nomina,$this->int_total_pagar);
            $request_update_nomina = $this->update_sql($sql_update_nomina,$data_nomina);

            $sql_update_detalle_nomina = "UPDATE detalle_nomina SET meses = ?, valor_total = ? WHERE id_nomina = $this->int_id_nomina and id_empleado = $this->int_id_empleado";
            $data_detalle_nomina = array($this->int_meses_nomina,$this->float_valor_total);
            $request_update_detalle_nomina =  $this->update_sql($sql_update_detalle_nomina,$data_detalle_nomina);
        }


        public function updateTotalNomina(int $int_id_nomina, int $int_total_pagar){
            $this->int_id_nomina = $int_id_nomina;
            $this->int_total_pagar = $int_total_pagar;
            $sql_update = "UPDATE nominas SET total = ? ,fecha_modifica = now() WHERE id_nomina = $this->int_id_nomina";
            $data_total = array($this->int_total_pagar);
            $request_update_total =  $this->update_sql($sql_update,$data_total);
        }
        public function deleteDetalle(int $id_detalle_nomina){
            $this->int_id_detalle_nomina = $id_detalle_nomina;
            $sql_delete = "DELETE FROM detalle_nomina WHERE id_detalle_nomina = $this->int_id_detalle_nomina";
            $request_delete = $this->delete_sql($sql_delete);
            return $request_delete;
        }

    }
?>