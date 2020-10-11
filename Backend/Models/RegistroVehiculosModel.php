<?php

    class RegistroVehiculosModel extends Mysql
    {
        private $intIdPlaca;
        private $strPlaca;
        private $strDocumento;
        private $intTpDocumento;
        private $intTpVehiculo;
        private $strNumeroModelo;


        public function __construct()
        {
            parent::__construct();
        }

            public function selectVehiculos()
        {
            //extrae todos los tipos de vehiculos
            $sql = "SELECT v.placa, u.num_documento, tpd.acronimo_td, tpv.nom_vehiculo, v.numero_modelo
            FROM vehiculo v 
            INNER JOIN usuario u ON v.fk_num_documento= u.num_documento 
            INNER JOIN tipo_documento tpd ON v.fk_id_tp_documento = tpd.id_tp_documento 
            INNER JOIN tipo_vehiculo tpv ON v.fk_id_tp_vehiculo = tpv.id_tp_vehiculo 
            WHERE v.placa != 'A'";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectUsuarios()
        {
            //extrae usuarios
            $sql = "SELECT * FROM usuario 
            WHERE num_documento != 0;
            ";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectTpDocumento()
        {
            //extrae usuarios
            $sql = "SELECT * FROM tipo_documento 
            WHERE id_tp_documento != 0;
            ";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectTipoVehiculos()
        {
            //extrae todos los tipos de vehiculos
            $sql = "SELECT * FROM tipo_vehiculo WHERE id_tp_vehiculo != 0";
            $request = $this->select_all($sql);
            return $request;
        }




//________________________________________________________________________________________________________________________________________
        public function selectionVehiculo(string $strPlaca)
        {
            $this->strPlaca = $strPlaca;
            $sql = "SELECT * FROM vehiculo WHERE placa = $this->strPlaca";
            $request = $this->select($sql);
            return $request;
        }
        //Actualiza los datos de un tipo de vehiculo
        public function updateVehiculo(string $strPlaca, string $strDocumento, int $intTpDocumento,
        int $intTpVehiculo, string $strNumeroModelo)
        {
            $this->strPlaca = $strPlaca;
            $this->strDocumento = $strDocumento;
            $this->intTpDocumento = $intTpDocumento;
            $this->intTpVehiculo = $intTpVehiculo;
            $this->strNumeroModelo = $strNumeroModelo;
            $return = "";

            $sql = "SELECT * FROM vehiculo WHERE
            placa = '{$this->strPlaca}' AND fk_num_documento = '{$this->strDocumento}'";
            $request = $this->select_all($sql);

            if(empty($request))
            {
                $sql = "UPDATE vehiculo SET placa = ?, fk_num_documento = ?, fk_id_tp_documento = ?, 
                fk_id_tp_vehiculo = ?, numero_modelo = ? WHERE placa = '{$this->strPlaca}'";
                $arrData = array($this->strPlaca, 
                                 $this->strDocumento, 
                                 $this->intTpDocumento, 
                                 $this->intTpVehiculo, 
                                 $this->strNumeroModelo);
                $request = $this->update($sql,$arrData);
            }else{
                $request = "exist";
            }
            return $request;
        }



//_____________________________________________________________________________________________________________________________________
        //Insertar un vehiculo
        public function insertVehiculo(string $strPlaca, string $strDocumento, int $intTpDocumento,
        int $intTpVehiculo, string $strNumeroModelo){
            $this->strPlaca = $strPlaca;
            $this->strDocumento = $strDocumento;
            $this->intTpDocumento = $intTpDocumento;
            $this->intTpVehiculo = $intTpVehiculo;
            $this->strNumeroModelo = $strNumeroModelo;
            $return = "";


            $sql = "SELECT * FROM vehiculo WHERE
                 placa = '{$this->strPlaca}'";
            $request = $this->select_all($sql);

            if (empty($request)) {
                $query_insert = "INSERT INTO vehiculo(
                                placa,fk_num_documento,fk_id_tp_documento,fk_id_tp_vehiculo,numero_modelo)
                                VALUES(?,?,?,?,?)";
                $arrData = array($this->strPlaca,
                                 $this->strDocumento,
                                 $this->intTpDocumento,
                                 $this->intTpVehiculo,
                                 $this->strNumeroModelo);

                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else {
                $return = "exist";
            }
            return $return;
            
        }



//__________________________________________________________________________________________________________________________________
//Eliminar Vehiculo
        public function delVehiculo(string $strPlaca)
        {
            $this->strPlaca = $strPlaca;
        $sql = "SELECT * FROM vehiculo WHERE placa = '{$this->strPlaca}'";
            $request = $this->select_all($sql);
            if(empty($request))
            {
                //$sql="UPDATE parkingsoft.vehiculo SET status = ? WHERE placa = $this->strPlaca "
            $sql = "DELETE FROM vehiculo WHERE placa = '{$this->strPlaca}'";
                $arrData = array(0);
                $request = $this->update($sql,$arrData);
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