<?php

    class RegistroVehiculos extends Controllers{
        public function __construct()
        {
            parent::__construct();
        }

        public function RegistroVehiculos()
        {
            $data['page_id'] = 9;
            $data['page_tag'] = "Registro-Vehiculo";
            $data['page_title'] = "Registro-Vehiculo";
            $data['page_name'] = "Parkingsoft";
            $this->api->getApi($this,"registroVehiculos",$data);
        }
//____________________________________________________________________________________________________________________________________________________________________
        //Extraer todos los vehiculos
        public function getVehiculos()
        {
            $arrData = $this->model->selectVehiculos();
            for($i=0;$i< count($arrData);$i++){
            $arrData[$i]['options'] = '<div class="text-center">
            <button class="btn btn-primary btn-sm btnEditVehiculo"  rl="'.$arrData[$i]['placa'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger btn-sm btnDelVehiculo" rl="'.$arrData[$i]['placa'].'" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
            </div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }


//__________________________________________________________________________________________________________________________________________________________________________________
//Select en el formulario 
public function getSelectDocumentoVehiculos(){
    $htmlOption="";
    $arrData=$this->model->selectUsuarios();
    if (count($arrData)>0) {
        for ($i=0; $i < count($arrData); $i++) { 
            $htmlOption.='<option value="'.$arrData[$i]['num_documento'].'">'.$arrData[$i]['num_documento'].'</option>';
            
        }
    }
    echo $htmlOption;
    die();
}

public function getSelectTpDocumentoVehiculos(){
    $htmlOptions="";
    $arrData=$this->model->selectTpDocumento();
    if (count($arrData)>0) {
        for ($i=0; $i < count($arrData); $i++) { 
            $htmlOptions.='<option value="'.$arrData[$i]['id_tp_documento'].'">'.$arrData[$i]['acronimo_td'].'</option>';
        }
    }
    echo $htmlOptions;
    die();
}


public function getSelectTpVehiculo(){
    $htmlOptions="";
    $arrData=$this->model->selectTipoVehiculos();
    if (count($arrData)>0) {
        for ($i=0; $i < count($arrData); $i++) { 
            $htmlOptions.='<option value="'.$arrData[$i]['id_tp_vehiculo'].'">'.$arrData[$i]['nom_vehiculo'].'</option>';
            
        }
    }
    echo $htmlOptions;
    die();
}






//___________________________________________________________________________________________________________________________

        //extrae un solo tipo de vehiculo
        /*public function getVehiculo(string $placa)
        {
            $strPlaca = strval($strPlaca);
            if ($strPlaca > 0) {
                $arrData = $this->model->selectVehiculo($strPlaca);
                if(empty($arrData)){
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                }else{
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
            
        }*/

//_______________________________________________________________________________________________________________________

        //Nuevo vehiculo
        public function setVehiculo(){
            if ($_POST) {
               //dep($_POST);
               if (empty($_POST['txtPlaca']) || empty($_POST['txtDocumento']) || empty($_POST['txtTpDocumento']) ||
               empty($_POST['txtTpVehiculo']) || empty($_POST['txtNumeroModelo'])) {

                   $arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
               }else{
                   
                   $strPlaca = strval($_POST['txtPlaca']);
                   $strDocumento = strval($_POST['txtDocumento']);
                   $intTpDocumento = intval($_POST['txtTpDocumento']);
                   $intTpVehiculo = intval($_POST['txtTpVehiculo']);
                   $strNumModelo = strval($_POST['txtNumeroModelo']);

                   $request_user = $this->model->insertVehiculo($strPlaca,
                                                                $strDocumento,
                                                                $intTpDocumento,
                                                                $intTpVehiculo,
                                                                $strNumModelo);
                
                    if ($request_user > 0) {
                        $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                    }else if ($request_user ==  'exist') {
                        $arrResponse = array('status' => false, 'msg' => 'Los datos ya existen. Ingrese otros datos');
                    }else {
                        $arrResponse = array("status" => true, "msg" => "Datos guardados correctamente.");
                    }
               }
               echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            
            }
            die();
                  
        }


//_____________________________________________________________________________________________________________________________

  //Eliminar el vehiculo
  public function DelVehiculo()
  {
      if($_POST){
          $strPlaca = strval(strClean($_POST['placa']));
          $requestDeleteVs = $this->model->deleteVehiculo($strPlaca);
          if($requestDeleteVs == "ok")
          {
              $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Tipo de Vehiculo');
          }else if($requestDeleteVs == "exist"){
              $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar el vehiculo.');
          }else{
              $arrResponse = array('status' => false, 'msg' => 'Error a el Eliminar el vehiculo.');
          }
          echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
      }
      die();
  }
        

    }

?>