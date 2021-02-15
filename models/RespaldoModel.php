<?php
    require_once("./libraries/core/mysql.php");
    class RespaldoModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }

        public function respaldo_sql(string $query){
            $con=mysqli_connect("localhost","root","","nominas_bd");
            mysqli_set_charset($con, "utf8");
            if (mysqli_connect_errno()) {
                printf("Conexion fallida: %s\n", mysqli_connect_error());
                exit();
            }else{
                mysqli_autocommit($con, false);
                mysqli_begin_transaction($con, MYSQLI_TRANS_START_WITH_CONSISTENT_SNAPSHOT);
                if($consul=mysqli_query($con, $query)){
                    if (!mysqli_commit($con)) {
                        print("Falló la consignación de la transacción\n");
                        exit();
                    }
                }else{
                    mysqli_rollback($con);
                    echo "Falló la transacción";
                    exit();
                }
                return $consul;
            }
        }
        
        
    }

?>