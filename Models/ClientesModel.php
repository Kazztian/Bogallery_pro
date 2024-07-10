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
}
