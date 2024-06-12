<?php
class LoginModel extends mysql
{
    private $intIdUsuario;
    private $strUsuario;
    private $strPassword;
    private $strToken;

    function __construct()
    {
        parent::__construct();
    }

    public function loginUser(string $usuario, string $password)
    {
        $this->strUsuario = $usuario;
        $this->strPassword = $password;
        $sql = "SELECT id_usuario, status FROM usuarios WHERE 
                email_user = '$this->strUsuario' and
                password = '$this->strPassword' and
                status != 0";
        $request = $this->select($sql);
        return $request;
    }

    public function sessionLogin(int $idUser)
    {
        $this->intIdUsuario = $idUser;
        // Buscar role
        $sql = "SELECT u.id_usuario,
                       u.nombres,
                       u.apellidos,
                       u.edad,
                       u.telefono,
                       u.email_user,
                       u.direccion,
                       u.primer_idioma ,
                       u.segundo_idioma,
                       r.id_rol, r.nombrerol,
                       u.status
                FROM usuarios u
                INNER JOIN rol r
                ON u.id_rol = r.id_rol
                WHERE u.id_usuario = $this->intIdUsuario";
        $request = $this->select($sql);
        return $request;
    }
}
?>
