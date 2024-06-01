
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
//Se reciben todos los datos que se envian desde el controlador Usuarios
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
        $this->intStatus = $status;
        $return = 0;
//Validacion para el email y saber si ya existe ese email
        $sql = "SELECT * FROM usuarios WHERE email_user = '{$this->strEmail}'";

        $request = $this->select_all($sql);
/*Lo que hace $request es buscar y si no encuentra singun usuario con ese email 
deja registrar los datos del usuario  */
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

    //Metodos para seleccionar y extraer los usuarios y el nombre rol
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
    /*Nos sirve para extraer los datos y mostrarlos en el modal
    por medio de una sentencia sql */
    public function selectUsuario(int $id_usuario)
    {
        $this->intIdUsuario = $id_usuario;
        $sql = "SELECT u.id_usuario, u.nombres, u.apellidos, u.edad, u.telefono, u.email_user, u.direccion, u.primer_idioma, u.segundo_idioma, u.status, r.id_rol, r.nombrerol,
    DATE_FORMAT(u.datecreated, '%d-%m-%Y') as fechaRegistro
    FROM usuarios u
    INNER JOIN rol r
    ON u.id_rol = r.id_rol
    WHERE u.id_usuario = $this->intIdUsuario";

        $request = $this->select($sql);
        return $request;
    }
//Metodo para actualizar un usuario
    public function updateUsuario(
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
        int $tipoid,
        int $status
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
        $this->intTipoId = $tipoid;
        $this->intStatus = $status;

        $sql = "SELECT * FROM usuarios WHERE (email_user = '{$this->strEmail}' AND id_usuario != $this->intIdUsuario)";
        $request = $this->select_all($sql);

        if (empty($request)) {
            if ($this->strPassword != "") {
                $sql = "UPDATE usuarios SET nombres=?, apellidos=?, edad=?, telefono=?, email_user=?, password=?, direccion=?, primer_idioma=?, segundo_idioma=?, id_rol=?, status=? WHERE id_usuario = $this->intIdUsuario";
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
            } else {
                $sql = "UPDATE usuarios SET nombres=?, apellidos=?, edad=?, telefono=?, email_user=?, direccion=?, primer_idioma=?, segundo_idioma=?, id_rol=?, status=? WHERE id_usuario = $this->intIdUsuario";
                $arrData = array(
                    $this->strNombre,
                    $this->strApellido,
                    $this->intEdad,
                    $this->intTelefono,
                    $this->strEmail,
                    $this->strDireccion,
                    $this->strPrimerI,
                    $this->strSegundoI,
                    $this->intTipoId,
                    $this->intStatus
                );
            }
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }
//Metodo para eliminar un usuario
    public function deleteUsuario(int $intIdUsuario)
    {
        $this->intIdUsuario = $intIdUsuario;
        $sql = "UPDATE usuarios SET status = ? WHERE id_usuario = $this->intIdUsuario";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);

        return $request;
    }
}
?>
