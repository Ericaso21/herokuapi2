<?php

    class Usuarios extends Controllers{
        public function __construct()
        {
            parent::__construct();
        }

        public function usuarios()
        {
            $data['page_id'] = 3;
            $data['page_tag'] = "Usuarios";
            $data['page_name'] = "Registro_usuarios";
            $data['page_title'] = "Registro usuarios <small> Parkingsoft </small>";
            $this->api->getApi($this,"usuarios",$data);
        }

        //Extraer todos los usuarios
        public function getUsuarios()
        {
            $arrData = $this->model->selectUsuarios();

            for($i=0;$i< count($arrData);$i++){

                if($arrData[$i]['estado'] == 0){
                    $arrData[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                }else{
                    $arrData[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                $arrData[$i]['options'] = '<div class="text-center">
                <button class="btn btn-primary btn-sm btnEditUsuario"  rl="'.$arrData[$i]['num_documento'].'" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger btn-sm btnDelUsuario" rl="'.$arrData[$i]['num_documento'].'" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                </div>';
            }

            
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        //extraer un usuario

        public function getUsuario(string $idUsuario)
        {
            $intIdRol = strClean($idUsuario);

            if (ctype_alnum($intIdRol)) {
                $arrData = $this->model->selectUsuario($idUsuario);
                if(empty($arrData)){
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                }else{
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
            
        }

        //Crear un usuario
        public function setUsuarios()
        {
                if($_POST){
                    $password = sha1($_POST['txtPassword']);
                    $strIdUsuario = strval(strClean($_POST['idUsuario']));
                    $strDocumento = strClean($_POST['txtDocumento']);
                    $intTpDocumento = intval($_POST['intTpdocumento']);
                    $intGenero = intval($_POST['txtGenero']);
                    $strUsuario = strClean($_POST['txtUsuario']);
                    $strNom1 = strClean($_POST['txtNombre1']);
                    $strNom2 = strClean($_POST['txtNombre2']);
                    $strApel1 = strClean($_POST['txtApellido1']);
                    $strApel2 = strClean($_POST['txtApellido2']);
                    $strEmail = strClean($_POST['txtEmail']);
                    $strPassword = strClean($password);
                    $intRol = intval($_POST['intRol']);
                    $intEstado = intval($_POST['estadoUs']);
                    if ($strIdUsuario == 0) {
                        //crea un nuevo usuario
                        $request_usuarios = $this->model->InsertUsuario($strDocumento, $intTpDocumento, $intGenero, $strUsuario, $strNom1, $strNom2, $strApel1, $strApel2, $strEmail, $strPassword);
                        $request_rol = $this->model->InsertRol($strDocumento, $intTpDocumento, $intRol, $intEstado);
                        $option = 1;
                    } else {
                        // Actualiza un usuario
                        $request_usuarios = $this->model->updateUsuario($strIdUsuario, $intGenero, $strUsuario, $strNom1, $strNom2, $strApel1, $strApel2, $strEmail);
                        $request_rol = $this->model->updateRol($strIdUsuario, $intRol, $intEstado);
                        $option = 2;
                    }

                if (is_int($request_usuarios) == is_int($request_rol)) 
                {
                if($option == 1)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                }else{
                    $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                }    
                } else if ($request_usuarios == 'exist' and $request_rol == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! El usuario ya existe.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos');
                }

                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();
            }
            
    }

    //Eliminar el Usuuario
    public function DelUsuario()
    {
        if($_POST){
            $strIdUsuario = strval(strClean($_POST['idUsuario']));
            $requestDeleteUs = $this->model->deleteUsuario($strIdUsuario);
            if($requestDeleteUs == "ok")
            {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Usuario');
            }else if($requestDeleteUs == "exist"){
                $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Usuario asociado a vehiculos.');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'Error a el Eliminar el Usuario.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    }

?>