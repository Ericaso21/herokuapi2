<?php

    class TipoVehiculoModel extends Mysql
    {
        public $strNomVehiculo;
        public $intIdTipoVehiculo;

        public function __construct()
        {
            parent::__construct();
        }

        public function selectTipoVehiculos()
        {
            //extrae todos los tipos de vehiculos
            $sql = "SELECT * FROM tipo_vehiculo WHERE id_tp_vehiculo != 0";
            $request = $this->select_all($sql);
            return $request;
        }

        //LLenar un select tipo vehiculo
        public function selectTpVehiculo()
        {
            //Extrae tipo vehiculo
            $sql = "SELECT * FROM tipo_vehiculo WHERE id_tp_vehiculo != 0";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectTipoVehiculo(string $intIdTpVehiculo)
        {
            $this->intIdTipoVehiculo = $intIdTpVehiculo;
            $sql = "SELECT * FROM tipo_vehiculo WHERE id_tp_vehiculo = $this->intIdTipoVehiculo";
            $request = $this->select($sql);
            return $request;
        }
        //Actualiza los datos de un tipo de vehiculo
        public function updateTpVehiculo(int $intIdTipoVehiculo, string $strNomVehiculo)
        {

            $this->intIdTipoVehiculo = $intIdTipoVehiculo;
            $this->strNomVehiculo = $strNomVehiculo;

            $sql = "SELECT * FROM tipo_vehiculo WHERE nom_vehiculo = '{$this->strNomVehiculo}' AND id_tp_vehiculo != '{$this->intIdTipoVehiculo}'";
            $request = $this->select_all($sql);

            if(empty($request))
            {
                $sql = "UPDATE tipo_vehiculo SET nom_vehiculo = ? WHERE id_tp_vehiculo = $this->intIdTipoVehiculo";
                $arrData = array($this->strNomVehiculo);
                $request = $this->update($sql,$arrData);
            }else {
                $request = "exist";
            }
            return $request;

        }
        //Inserta un tipo de vehiculo
        public function InsertTpVehiculo(string $strNomVehiculo)
        {
            $return = "";
            $this->strNomVehiculo = $strNomVehiculo;
            
        $sql = "SELECT * FROM tipo_vehiculo WHERE nom_vehiculo = '{$this->strNomVehiculo}'";
        $request = $this->select_all($sql);
        if(empty($request)){
            $sql = "INSERT INTO tipo_vehiculo(nom_vehiculo) VALUES(?)";
            $arrData = array($this->strNomVehiculo);
            $query_request = $this->insert($sql,$arrData);
            return $query_request;
        }else{
            $return = "exist";
        }
        return $return;
        }

        public function deleteTipoVehiculo(int $intIdTpVehiculo)
        {
            $this->intIdTipoVehiculo = $intIdTpVehiculo;
            $sql = "SELECT * FROM tarifas WHERE fk_id_tp_vehiculo = $this->intIdTipoVehiculo";
            $request = $this->select_all($sql);
            if(empty($request))
            {
                $sql = "DELETE FROM tipo_vehiculo WHERE id_tp_vehiculo = $this->intIdTipoVehiculo";
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