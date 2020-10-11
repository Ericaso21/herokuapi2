<?php

    class Tarifas extends Controllers{
        public function __construct()
        {
            parent::__construct();
        }

        public function tarifas()
        {
            $data['page_id'] = 7;
            $data['page_tag'] = "Tarifas";
            $data['page_title'] = "Tarifas-Vehiculos";
            $data['page_name'] = "Tarifas_vehiculo";
            $this->api->getApi($this,"tarifas",$data);
        }

        //Extraer todas las tarifas
        public function getTarifas()
        {
            $arrData = $this->model->selectTarifas();

            for($i=0;$i< count($arrData);$i++){

                $arrData[$i]['options'] = '<div class="text-center">
                <button class="btn btn-primary btn-sm btnEditTarifa"  rl="'.$arrData[$i]['id_tarifas'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger btn-sm btnDelTarifa" rl="'.$arrData[$i]['id_tarifas'].'" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                </div>';
            }

            
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        //extrae una sola tarifa 
        public function getTarifa(int $idTarifa)
        {
            $intidTarifa = intval($idTarifa);
            if ($idTarifa > 0) {
                $arrData = $this->model->selectTarifa($intidTarifa);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
                }else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        //insertar tarifa
        public function setTarifas()
        {
            if ($_POST) {
                $intIdTarifa = intval($_POST['idTarifa']);
                $intTpVehiculo = intval($_POST['listTipoVehiculo']);
                $floatTarifaMinuto = floatval($_POST['floatTarifaMinuto']);
                $floatTarifaHora = floatval($_POST['floatTarifaHora']);
                $floatTarifaDia = floatval($_POST['floatTarifaDia']);

                if ($intIdTarifa == 0) {
                    //crea una nueva tarifa
                    $request_tarifa = $this->model->insertTarifa($intTpVehiculo, $floatTarifaMinuto, $floatTarifaHora, $floatTarifaDia);
                    $option = 1;
                }else {
                    $request_tarifa = $this->model->updateTarifa($intIdTarifa, $intTpVehiculo, $floatTarifaMinuto, $floatTarifaHora, $floatTarifaDia);
                    $option = 2;
                }

                if ($request_tarifa > 0) 
                {
                if($option == 1)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                }else{
                    $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                }    
                } else if ($request_tarifa == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! La Tarifa ya existe.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos');
                }

                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();
            }
        }

    }

?>