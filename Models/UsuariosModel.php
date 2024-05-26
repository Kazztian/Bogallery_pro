
<?php

class UsuariosModel extends mysql
{
    private $intIdUsuario;
    private    $strNombre;
    private    $strApellido;
    private    $intTelefono;
    private     $strEmail;
    private $strPassword;
    private     $intEdad;
    private    $strDireccion;
    private    $strPrimerI;
    private     $strSegundoI;
    private     $strToken;
    private     $intTipoId;
    private     $intStatus;

    function __construct()
    {
        parent::__construct();
    }

    public function insertUsuario(
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
        int $status
    ) {

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
        $this->intStatus = $status;
        $return = 0;

        $sql = "SELECT * FROM usuarios WHERE email_user = '{$this->strEmail}'";

        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO usuarios(
             nombres, apellidos, edad, telefono, email_user, password, direccion, primer_idioma, segundo_idioma, id_rol,status)  
              VALUES(?,?,?,?,?,?,?,?,?,?,?)";

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
                $this->intStatus
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $request = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    //Metodos para seleccionar los usuarios y el nombre rol
    public function selectUsuarios()
    {
        $sql = "SELECT u.id_usuario, u.nombres, u.apellidos, u.edad, u.telefono, u.email_user, u.primer_idioma, u.status, r.nombrerol
        FROM usuarios u
        INNER JOIN rol r
        ON u.id_rol = r.id_rol
        WHERE u.status != 0 ";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectUsuario(int $id_usuario)
    {
        $this->intIdUsuario = $id_usuario;
        $sql = "SELECT u.id_usuario, u.nombres, u.apellidos, u.edad, u.telefono, u.email_user, u.primer_idioma, u.segundo_idioma, u.status, r.id_rol, r.nombrerol,
    DATE_FORMAT(u.datecreated, '%d-%m-%Y') as fechaRegistro
    FROM usuarios u
    INNER JOIN rol r
    ON u.id_rol = r.id_rol
    WHERE u.id_usuario = $this->intIdUsuario";

        $request = $this->select($sql);
        return $request;
    }
}
?>
