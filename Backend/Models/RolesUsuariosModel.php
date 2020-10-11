<?php

    class RolesUsuariosModel extends Mysql
    {
        public $intIdRol;
        public $strRol;
        public $strDescripcion;
        public $intStatus;
        
        public function __construct()
        {
            parent::__construct();
        }

        public function selectRoles()
        {
            //extrae todos los roles
            $sql = "SELECT * FROM rol WHERE id_rol != 0";
            $request = $this->select_all($sql);
            return $request;
        }

        //Extrae solo una tarifa 
        public function selectRol(int $intRol)
        {
            $this->intIdRol = $intRol;
            $sql = "SELECT * FROM rol WHERE id_rol = $this->intIdRol ";
            $request = $this->select($sql);
            return $request;
        }

        public function insertRol(string $rol, string $descripcion, int $status){
            $return = "";
            $this->strRol = $rol;
            $this->strDescripcion = $descripcion;
            $this->intStatus = $status;

            $sql = "SELECT * FROM rol WHERE nombre_rol = '{$this->strRol}'";
            $request = $this->select_all($sql);

            if(empty($request))
            {
                $query_insert = "INSERT INTO rol(nombre_rol, descripcion, estado) VALUES(?,?,?)";
                $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;

        }

        public function updateRol(int $strIdRol, string $strNombreRol,string $strDescripcion, int $intstatus)
        {
            $this->intIdRol = $strIdRol;
            $this->strRol = $strNombreRol;
            $this->strDescripcion = $strDescripcion;
            $this->intStatus = $intstatus;

            $sql = "SELECT * FROM rol WHERE nombre_rol = '{$this->strRol}' AND id_rol != '{$this->intIdRol}'";
            $request = $this->select_all($sql);

            if (empty($request)) {
                $sql = "UPDATE rol SET nombre_rol = ?, descripcion = ?, estado = ? WHERE id_rol = $this->intIdRol";
                $arrData = array($this->strRol,$this->strDescripcion,$this->intStatus);
                $request = $this->update($sql,$arrData);
            }else{
                $request = "exist";
            }
            return $request;
        }

        public function deleteTipoVehiculo(int $intIdRol)
        {
            $this->intIdRol = $intIdRol;
            $sql = "SELECT * FROM persona_rol WHERE pk_fk_id_rol = $this->intIdRol";
            $request = $this->select_all($sql);
            if(empty($request))
            {
                $sql = "DELETE FROM rol WHERE id_rol = $this->intIdRol";
                $request = $this->delete($sql);
                if($request)
                {
                    $request = 'ok';
                }else{
                    $request = 'error';
                }
            }else{
                $request = 'exist';
            }
            return $request;
        }

    }

    

?>