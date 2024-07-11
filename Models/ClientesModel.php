<?php

class ClientesModel extends mysql
{
    private    $intIdUsuario;
    private    $strNombre;
    private    $strApellido;
    private    $intTelefono;
    private    $strEmail;
    private    $strPassword;
    private    $intEdad;
    private    $strDireccion;
    private    $strPrimerI;
    private     $strSegundoI;
    private     $strToken;
    private     $intTipoId;
    private     $intStatus;
    private $strNit;
    private $strNomFiscal;
    private $strDirFiscal;

    function __construct()
    {
        parent::__construct();
    }
    //Se reciben todos los datos que se envian desde el controlador Usuarios
    public function insertCliente(
        string $nombre,
        string $apellido,
        int $telefono,
        string $email,
        string $password,
        int $edad,
        string $direccion,
        string $primeri,
        string $segundoi,
        int $tipoid,
        string $nit,
        string $nomFiscal,
        string $dirFiscal

    ) {
        //Se asignan los valores declarados en la parte superior 
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->intEdad = $edad;
        $this->strDireccion = $direccion;
        $this->strPrimerI = $primeri;
        $this->strSegundoI = $segundoi;
        $this->intTipoId = $tipoid;
        $this->strNit = $nit;
        $this->strNomFiscal = $nomFiscal;
        $this->strDirFiscal = $dirFiscal;
        $return = 0;
        //Validacion para el email y saber si ya existe ese email
        $sql = "SELECT * FROM usuarios WHERE email_user = '{$this->strEmail}'";

        $request = $this->select_all($sql);
        /*Lo que hace $request es buscar y si no encuentra singun usuario con ese email 
deja registrar los datos del usuario  */
        if (empty($request)) {
            $query_insert = "INSERT INTO usuarios(
             nombres, apellidos, edad, telefono, email_user, password, direccion, primer_idioma, segundo_idioma, id_rol,nit,nombrefiscal,direccionfiscal)  
              VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $arrData = array(
                $this->strNombre,
                $this->strApellido,
                $this->intEdad,
                $this->intTelefono,
                $this->strEmail,
                $this->strPassword,
                $this->strDireccion,
                $this->strPrimerI,
                $this->strSegundoI,
                $this->intTipoId,
                $this->strNit,
                $this->strNomFiscal,
                $this->strDirFiscal
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $request = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }
    public function selectClientes()
    {

        $sql = "SELECT id_usuario, nombres, apellidos, edad, telefono, email_user, primer_idioma, status
        FROM usuarios 
       
        WHERE id_rol = 2 and status != 0 ";

        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCliente(int $id_usuario)
    {
        $this->intIdUsuario = $id_usuario;
        $sql = "SELECT id_usuario, nombres, apellidos, edad, telefono, email_user, nit, nombrefiscal,direccionfiscal, direccion, primer_idioma, segundo_idioma, status, 
    DATE_FORMAT(datecreated, '%d-%m-%Y') as fechaRegistro
    FROM usuarios 
    WHERE id_usuario = $this->intIdUsuario and id_rol = 2";

        $request = $this->select($sql);
        return $request;
    }

    public function updateCliente(
        int $idUsuario,
        string $nombre,
        string $apellido,
        int $telefono,
        string $email,
        string $password,
        int $edad,
        string $direccion,
        string $primeri,
        string $segundoi,
        string $nit,
        string $nomFiscal,
        string $dirFiscal

    ) {
        $this->intIdUsuario = $idUsuario;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->intEdad = $edad;
        $this->strDireccion = $direccion;
        $this->strPrimerI = $primeri;
        $this->strSegundoI = $segundoi;
        $this->strNit = $nit;
        $this->strNomFiscal = $nomFiscal;
        $this->strDirFiscal = $dirFiscal;


        $sql = "SELECT * FROM usuarios WHERE (email_user = '{$this->strEmail}' AND id_usuario != $this->intIdUsuario)";
        $request = $this->select_all($sql);

        if (empty($request)) {
            if ($this->strPassword != "") {
                $sql = "UPDATE usuarios SET nombres=?, apellidos=?, edad=?, telefono=?, email_user=?, password=?, direccion=?, primer_idioma=?, segundo_idioma=?,  nit=?, nombrefiscal=?, direccionfiscal=?  WHERE id_usuario = $this->intIdUsuario";
                $arrData = array(
                    $this->strNombre,
                    $this->strApellido,
                    $this->intEdad,
                    $this->intTelefono,
                    $this->strEmail,
                    $this->strPassword,
                    $this->strDireccion,
                    $this->strPrimerI,
                    $this->strSegundoI,
                    $this->strNit,
                    $this->strNomFiscal,
                    $this->strDirFiscal
                );
            } else {
                $sql = "UPDATE usuarios SET nombres=?, apellidos=?, edad=?, telefono=?, email_user=?, direccion=?, primer_idioma=?, segundo_idioma=?, nit=?, nombrefiscal=?, direccionfiscal=?  WHERE id_usuario = $this->intIdUsuario";
                $arrData = array(
                    $this->strNombre,
                    $this->strApellido,
                    $this->intEdad,
                    $this->intTelefono,
                    $this->strEmail,
                    $this->strDireccion,
                    $this->strPrimerI,
                    $this->strSegundoI,
                    $this->strNit,
                    $this->strNomFiscal,
                    $this->strDirFiscal
                );
            }
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteCliente(int $intIdUsuario)
    {
        $this->intIdUsuario = $intIdUsuario;
        $sql = "UPDATE usuarios SET status = ? WHERE id_usuario = $this->intIdUsuario";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        return $request;
    }
}
