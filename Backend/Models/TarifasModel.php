<?php

    class TarifasModel extends Mysql
    {
        public $intIdTarifa;
        public $intTpVehiculo;
        public $floatTarifaMinuto;
        public $floatTarifaHora;
        public $floatTarifaDia;

        public function __construct()
        {
            parent::__construct();
        }

        
        public function selectTarifas()
        {
            //extrae usuarios
            $sql = "SELECT * FROM tipo_vehiculo tp INNER JOIN tarifas t ON t.fk_id_tp_vehiculo = tp.id_tp_vehiculo WHERE id_tarifas != 0;  ";
            $request = $this->select_all($sql);
            return $request;
        }
        //Extrae solo una tarifa 
        public function selectTarifa(int $intIdTarifa)
        {
            $this->intIdTarifa = $intIdTarifa;
            $sql = "SELECT * FROM tarifas WHERE id_tarifas = $this->intIdTarifa";
            $request = $this->select($sql);
            return $request;
        }

        public function insertTarifa(int $intTpVehiculo, float $floatTarifaMinuto, float $floatTarifaHora, float $floatTarifaDia)
        {
            $return = "";
            $this->intTpVehiculo = $intTpVehiculo;
            $this->floatTarifaMinuto = $floatTarifaMinuto;
            $this->floatTarifaHora = $floatTarifaHora;
            $this->floatTarifaDia = $floatTarifaDia;

            $sql = "SELECT * FROM tarifas WHERE fk_id_tp_vehiculo = '{$this->intTpVehiculo}'";
            $request = $this->select_all($sql);

            if (empty($request)) {
                $query_insert = "INSERT INTO tarifas(tarifa_minuto, tarifa_hora, tarifa_dia, fk_id_tp_vehiculo) VALUES (?,?,?,?)";
                $arrData = array($this->floatTarifaMinuto, $this->floatTarifaHora, $this->floatTarifaDia, $this->intTpVehiculo);
                $request_insert = $this->insert($query_insert,$arrData);
                return $request_insert;
            }else {
                $return = "exist";
            }
            return $return;
        }

        public function updateTarifa(int $intIdTarifa, int $intTpVehiculo, float $floatTarifaMinuto, float $floatTarifaHora, float $floatTarifaDia)
        {
            $this->intIdTarifa = $intIdTarifa;
            $this->intTpVehiculo = $intTpVehiculo;
            $this->floatTarifaMinuto = $floatTarifaMinuto;
            $this->floatTarifaHora = $floatTarifaHora;
            $this->floatTarifaDia = $floatTarifaDia;

            $sql = "SELECT * FROM tarifas WHERE fk_id_tp_vehiculo = '$this->intTpVehiculo' AND id_tarifa != '$this->intIdTarifa'";
            $request = $this->select_all($sql);

            if (empty($request)) {
                
            }
        }
        



    }

?>