<?php

    class LoginModel extends Mysql
    {
        private $intIdUsuario;
        private $strUsuario;
        private $strPassword;
        private $strToken;
        private $strNom1;
        private $strNom2;
        private $strApel1;
        private $strApel2;
        private $strDocumento;
        private $intTpDoc;
        private $intRol;
        private $intGenero;
        private $strNomUs;
        private $strEmailUs;
        private $strPasswordUs;
        private $intEstado;

        public function __construct()
        {
            parent::__construct();
        }

        public function loginUser(string $usuario, string $password)
        {
            $this->strUsuario = $usuario;
            $this->strPassword = $password;
            $sql = "SELECT u.num_documento, pr.estado FROM usuario u inner join persona_rol pr on pr.pk_fk_num_documento = u.num_documento  WHERE
                    correo_electronico = '$this->strUsuario' AND
                    contrasena = '$this->strPassword'";
            $request = $this->select($sql);
            return $request;
        }

        public function InsertUsuario(string $strNom1,string $strNom2, string $strApel1, string $strApel2, string $strDocumento,int $intTpDoc,int $intGenero, string $strNomUs, string $strEmailUs, string $strPasswordUs)
        {
            $return = "";
            $this->strNom1 = $strNom1;
            $this->strNom2 = $strNom2;
            $this->strApel1 = $strApel1;
            $this->strApel2 = $strApel2;
            $this->strDocumento = $strDocumento;
            $this->intTpDoc = $intTpDoc;
            $this->intGenero = $intGenero;
            $this->strNomUs = $strNomUs;
            $this->strEmailUs = $strEmailUs;
            $this->strPasswordUs = $strPasswordUs;

            $sql = "SELECT * FROM usuario WHERE num_documento = '{$this->strDocumento}'";
            $request = $this->select_all($sql);

            if (empty($request)) {
                $query_insert = "INSERT INTO usuario(num_documento, pk_fk_id_tp_documento, fk_id_genero, nom_usuario, prim_nom,
                seg_nombre, prim_apellido, seg_apellido, correo_electronico, contrasena) VALUES (?,?,?,?,?,?,?,?,?,?)";
                $arrData = array($this->strDocumento, $this->intTpDoc, $this->intGenero, $this->strNomUs, $this->strNom1, $this->strNom2, $this->strApel1, $this->strApel2, $this->strEmailUs, $this->strPasswordUs);
                $request_insert = $this->insert($query_insert,$arrData);
                return $request_insert;
            }else
            {
                $return = "exist";
            }
            return $return;
        }

        public function InsertRol(string $strDocumento, int $intTpDocumento, int $intRol, int $intEstado)
        {
            $return = "";
            $this->strDocumento = $strDocumento;
            $this->intTpDoc = $intTpDocumento;
            $this->intRol = $intRol;
            $this->intEstado = $intEstado;

            $sql = "SELECT * FROM persona_rol WHERE pk_fk_num_documento = '{$this->strDocumento}'";
            $request_r = $this->select_all($sql);
            if (empty($request_r)) {
                $query_insert = "INSERT INTO persona_rol(pk_fk_num_documento, pk_fk_id_tp_documento, pk_fk_id_rol, estado) VALUES (?,?,?,?)";
                $arrData = array($this->strDocumento, $this->intTpDoc, $this->intRol, $this->intEstado);
                $request_insert = $this->insert($query_insert, $arrData);
                return $request_insert;
            }else {
                $return = "exist";
            }
            return $return;
        }

    }

?>