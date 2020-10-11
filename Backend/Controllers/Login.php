<?php

    class Login extends Controllers{
        public function __construct()
        {
            session_start();
            parent::__construct();
        }

        public function login()
        {
            $data['page_tag'] = "Login";
            $data['page_title'] = "Login";
            $data['page_name'] = "Parkingsoft";
            $data['page_functions_js'] = "functions_login.js";
            $this->api->getApi($this,"login",$data);
        }

        public function loginUser(){
            //dep($_POST);
            if($_POST){
                if(empty($_POST['txtEmail']) || empty($_POST['txtPassword'])){
                    $arrResponse = array('status' => false, 'msg' => 'Error de datos');
                }else{
                    $strUsuario = strtolower(strClean($_POST['txtEmail']));
                    $strPassword = sha1($_POST['txtPassword']);
                    $requestUser = $this->model->loginUser($strUsuario, $strPassword);
                    if(empty($requestUser)){
                        $arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.' );
                    }else{
                        $arrData = $requestUser;
                        if($arrData['estado'] == 0){
                            $_SESSION['idUser'] = $arrData['num_documento'];
                            $_SESSION['login'] = true;
                            $arrResponse = array('status' => true, 'msg' => 'ok');
                        }else{
                            $arrResponse = array('status' => false, 'msg' => 'Usuario inactivo');
                        }
                    }

                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function setUsuario()
        {
            if ($_POST) {
                $strNom1 = strval($_POST['txtNombre1']);
                $strNom2 = strval($_POST['txtNombre2']);
                $strApel1 = strval($_POST['txtApel1']);
                $strApel2 = strval($_POST['txtApel2']);
                $strDocumento = strval($_POST['txtNumDocumento']);
                $intTpDoc = intval($_POST['intTpdocumento']);
                $intGenero = intval($_POST['intGenero']);
                $intRol = 3;
                $intEstado = 0;
                $strNomUs = strval($_POST['txtNomUsuario']);
                $strEmailUs = strval($_POST['txtEmailUs']);
                $strPasswordUs = sha1($_POST['txtPasswordUs']);
                
                $request_insert = $this->model->InsertUsuario($strNom1,$strNom2,$strApel1,$strApel2,$strDocumento,$intTpDoc,$intGenero,$strNomUs,$strEmailUs,$strPasswordUs);
                $request_rol = $this->model->InsertRol($strDocumento,$intTpDoc,$intRol,$intEstado );
                if (is_int($request_insert)  == is_int($request_rol)) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                }elseif ($request_insert == 'exist' and $request_rol == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! El usuario ya existe.');
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos');
                }

                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();
            }
        }






    }

?>