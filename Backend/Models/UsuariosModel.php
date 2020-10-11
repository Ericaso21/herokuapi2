<?php

    class UsuariosModel extends Mysql
    {   
        public $stringIdUsuario;
        public $strDocumento;
        public $intTpDocumento;
        public $intGenero;
        public $strUsuario;
        public $strNom1;
        public $strNom2;
        public $strApel1;
        public $strApel2;
        public $strEmail;
        public $strPassword;
        public $intRol;
        public $intEstado;

        public function __construct()
        {
            parent::__construct();
        }

        public function selectUsuarios()
        {
            //extrae usuarios
            $sql = "SELECT u.num_documento, tpd.acronimo_td, g.acronimo, u.prim_nom, u.prim_apellido, u.nom_usuario, u.correo_electronico, pr.estado, r.nombre_rol FROM usuario as u 
            INNER JOIN tipo_documento as tpd ON u.pk_fk_id_tp_documento = tpd.id_tp_documento
            INNER JOIN genero as g ON u.fk_id_genero = g.id_genero INNER JOIN persona_rol as pr ON u.num_documento = pr.pk_fk_num_documento
            INNER JOIN rol as r ON pr.pk_fk_id_rol = r.id_rol WHERE id_rol != 0;
            ";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectUsuario(string $idUsuario)
        {
            //buscar usuario
            $this->stringIdUsuario = $idUsuario;
            $sql = "SELECT * FROM usuario as u 
            INNER JOIN tipo_documento as tpd ON u.pk_fk_id_tp_documento = tpd.id_tp_documento
            INNER JOIN genero as g ON u.fk_id_genero = g.id_genero INNER JOIN persona_rol as pr ON u.num_documento = pr.pk_fk_num_documento
            INNER JOIN rol as r ON pr.pk_fk_id_rol = r.id_rol  WHERE num_documento = $this->stringIdUsuario";
            $request = $this->select($sql);
            return $request;
        }

        public function InsertUsuario(string $strDocumento, int $intTpDocumento, int $intGenero,string $strUsuario ,string $strNom1, string $strNom2, string $strApel1, string $strApel2, string $strEmail, string $strPassword)
        {
            $return = "";
            $this->strDocumento = $strDocumento;
            $this->intTpDocumento = $intTpDocumento;
            $this->intGenero = $intGenero;
            $this->strUsuario = $strUsuario;
            $this->strNom1 = $strNom1;
            $this->strNom2 = $strNom2;
            $this->strApel1 = $strApel1;
            $this->strApel2 = $strApel2;
            $this->strEmail = $strEmail;
            $this->strPassword = $strPassword;

            $sql = "SELECT * FROM usuario WHERE num_documento = '{$this->strDocumento}'";
            $request = $this->select_all($sql);

            if (empty($request))
            {
                $query_insert = "INSERT INTO usuario(num_documento, pk_fk_id_tp_documento, fk_id_genero, nom_usuario, prim_nom,
                seg_nombre, prim_apellido, seg_apellido, correo_electronico, contrasena) VALUES(?,?,?,?,?,?,?,?,?,?)";
                $arrData = array($this->strDocumento, $this->intTpDocumento, $this->intGenero, $this->strUsuario, $this->strNom1,
                $this->strNom2, $this->strApel1, $this->strApel2, $this->strEmail, $this->strPassword);
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
            $this->intTpDocumento = $intTpDocumento;
            $this->intRol = $intRol;
            $this->intEstado = $intEstado;

            $sql = "SELECT * FROM persona_rol WHERE pk_fk_num_documento = '{$this->strDocumento}'";
            $request_r = $this->select_all($sql);
            if (empty($request_r)) {
                $query_insert = "INSERT INTO persona_rol(pk_fk_num_documento, pk_fk_id_tp_documento, pk_fk_id_rol, estado) VALUES (?,?,?,?)";
                $arrData = array($this->strDocumento, $this->intTpDocumento, $this->intRol, $this->intEstado);
                $request_insert = $this->insert($query_insert, $arrData);
                return $request_insert;
            }else {
                $return = "exist";
            }
            return $return;
        }

        public function updateUsuario(string $IdUsuario, int $Genero, string $Usuario, string $Nom1, string $Nom2, string $Apel1,string $Apel2,string $Email)
        {
            $this->stringIdUsuario = $IdUsuario;
            $this->intGenero = $Genero;
            $this->strUsuario = $Usuario;
            $this->strNom1 = $Nom1;
            $this->strNom2 = $Nom2;
            $this->strApel1 = $Apel1;
            $this->strApel2 = $Apel2;
            $this->strEmail = $Email;

            $sql = "SELECT * FROM usuario WHERE nom_usuario = '$this->strUsuario' AND num_documento != $this->stringIdUsuario ";
            $request = $this->select_all($sql);

            if(empty($request))
            {
                $sql = "UPDATE usuario SET fk_id_genero = ?, nom_usuario = ?, prim_nom = ?, seg_nombre = ?, prim_apellido = ?, seg_apellido = ?, correo_electronico = ? WHERE num_documento = $this->stringIdUsuario";
                $arrData = array($this->intGenero, $this->strUsuario, $this->strNom1, $this->strNom2, $this->strApel1, $this->strApel2, $this->strEmail);
                $request = $this->update($sql,$arrData);
            }else{
                $request = "exist";
            }
            return $request;
        }

        public function updateRol(string $IdUsuario, int $Rol, int $Estado)
        {
            $this->stringIdUsuario = $IdUsuario;
            $this->intRol = $Rol;
            $this->intEstado = $Estado;

            $sql = "SELECT * FROM persona_rol WHERE estado = '{$this->intEstado}' AND pk_fk_num_documento = $this->stringIdUsuario";
            $request = $this->select_all($sql);

            if(empty($request))
            {
                $sql = "UPDATE persona_rol SET pk_fk_id_rol = ?, estado = ? WHERE pk_fk_num_documento =  $this->stringIdUsuario " ;
                $arrData = array($this->intRol, $this->intEstado);
                $request = $this->update($sql,$arrData);
            }else{
                $request = "exist";
            }
            return $request;
        }

        public function deleteUsuario(string $idUsuario)
        {
            $this->stringIdUsuario = $idUsuario;
            $sql = "SELECT * FROM usuario WHERE num_documento = $this->stringIdUsuario";
            $request = $this->select_all($sql);
            if(empty($request))
            {
                $sql = "UPDATE persona_rol SET estado = ? WHERE pk_fk_num_documento  = $this->stringIdUsuario";
                $arrData = array(2);
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