<?php

    class TipoVehiculo extends Controllers{
        public function __construct()
        {
            parent::__construct();
        }

        public function tipoVehiculo()
        {
            $data['page_id'] = 8;
            $data['page_tag'] = "Tipo-Vehiculo";
            $data['page_title'] = "Tipo-Vehiculo";
            $data['page_name'] = "Tipo_vehiculo";
            $this->api->getApi($this,"tipoVehiculo",$data);
        }

                //Extraer todos los tipos de vehiculos
                public function getTipoVehiculos()
                {
                    $arrData = $this->model->selectTipoVehiculos();
        
                    for($i=0;$i< count($arrData);$i++){
                        $arrData[$i]['options'] = '<div class="text-center">
                        <button class="btn btn-primary btn-sm btnEditTpVehiculo"  rl="'.$arrData[$i]['id_tp_vehiculo'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-danger btn-sm btnDelTpVehiculo" rl="'.$arrData[$i]['id_tp_vehiculo'].'" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                        </div>';
                    }
                    echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
                    die();
                }
                // Extrae datos para un select 
                public function getSelectTpVehiculo()
                {
                    $htmlOptions = "";
                    $arrData = $this->model->selectTpVehiculo();
                    if (count($arrData) > 0) {
                        for ($i=0; $i < count($arrData) ; $i++) { 
                            $htmlOptions .= '<option value="'.$arrData[$i]['id_tp_vehiculo'].'">'.$arrData[$i]['nom_vehiculo'].'</option>';
                        }
                    }
                    echo $htmlOptions;
                    die();
                }
                //extrae un solo tipo de vehiculo
                public function getTipoVehiculo(string $intIdTipoVehiculo)
                {
                    $intIdTpVehiculo = strval($intIdTipoVehiculo);
        
                    if ($intIdTpVehiculo > 0) {
                        $arrData = $this->model->selectTipoVehiculo($intIdTpVehiculo);
                        if(empty($arrData)){
                            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                        }else{
                            $arrResponse = array('status' => true, 'data' => $arrData);
                        }
                        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    }
                    die();
                    
                }

                //Nuevo tipo vehiculo

                public function setTipoVehiculo()
                {
                        if($_POST){
                            $intIdTipoVehiculo = intval(strClean($_POST['idTpVehiculo']));
                            $strNomVehiculo = strClean($_POST['txtnomTp']);
                            if ($intIdTipoVehiculo == 0) {
                                //crea un nuevo usuario
                                $request_usuarios = $this->model->InsertTpVehiculo($strNomVehiculo);
                                $option = 1;
                            } else {
                                // Actualiza un usuario
                                $request_usuarios = $this->model->updateTpVehiculo($intIdTipoVehiculo, $strNomVehiculo);
                                $option = 2;
                            }
        
                        if ($request_usuarios > 0) 
                        {
                        if($option == 1)
                        {
                            $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        }else{
                            $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                        }    
                        } else if ($request_usuarios == 'exist') {
                            $arrResponse = array('status' => false, 'msg' => '¡Atención! El Tipo de vehiculo ya existe.');
                        } else {
                            $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos');
                        }
        
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                    
            }
    //Eliminar el Usuuario
    public function DelTipoVehiculo()
    {
        if($_POST){
            $intIdTpVehiculo = intval(strClean($_POST['idTpVehiculo']));
            $requestDeleteUs = $this->model->deleteTipoVehiculo($intIdTpVehiculo);
            if($requestDeleteUs == "ok")
            {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Tipo de Vehiculo');
            }else if($requestDeleteUs == "exist"){
                $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Tipo de vehiculo por que esta asociado a una Tarifa.');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'Error a el Eliminar Tipo de vehiculo.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}

?>