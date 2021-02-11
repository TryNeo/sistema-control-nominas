<?php
    require_once("./libraries/core/mysql.php");
    class PermisosModel extends Mysql{
        public $intIdpermiso;
        public $intIdRol;
        public $intModulo;
        public $r;
        public $w;
        public $u;
        public $d;

        public function __construct(){
            parent::__construct();
        }

        public function selectModulos(){
            $sql = "SELECT * FROM modulos WHERE estado != 0";
            $request = $this->select_sql_all($sql);
            return $request;
        }
        
        public function selectPermisoRol(int $idRol){
            $this->intIdRol = $idRol;
            $sql = "SELECT * FROM permisos WHERE id_rol = $this->intIdRol ";
            $request = $this->select_sql_all($sql);
            return $request;
        }

        public function deletePermisos(int $intIdRol){
            $this->intIdRol = $intIdRol;
            $sql = "DELETE FROM permisos  WHERE id_rol = $this->intIdRol";
            $request = $this->delete_sql($sql);
            return $request;
        }


        public function insertPermisos(int $idRol,int $idModulo,int $r,int $w,int $u,int $d){
            $this->intIdRol = $idRol;
            $this->intModulo = $idModulo;
            $this->r = $r;
            $this->w = $w;
            $this->u = $u;
            $this->d = $d;
            $queryInsert = "INSERT INTO permisos(id_modulo,id_rol,r,w,u,d) VALUES(?,?,?,?,?,?)";
            $data = array($this->intModulo,$this->intIdRol,$this->r,$this->w,$this->u,$this->d);
            $request_insert = $this->insert_sql($queryInsert,$data);
            return $request_insert;
        }


        public function permisoModel(int $idRol){
            $this->intIdRol = $idRol;
            $sql = "SELECT p.id_modulo,m.nombre,
                    p.id_rol,p.r,p.w,p.u,p.d 
                    FROM permisos p INNER JOIN modulos m ON p.id_modulo = m.id_modulo WHERE p.id_rol = $this->intIdRol";
            $request = $this->select_sql_all($sql);
            $arrPermisos = array();
            for ($i=0; $i < count($request); $i++) { 
                $arrPermisos[$request[$i]['id_modulo']] = $request[$i];
            }
            return $arrPermisos;
        }
    }

?>