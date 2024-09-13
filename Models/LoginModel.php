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
                       u.nit,
					   u.nombrefiscal,
					   u.direccionfiscal,
                       u.direccion,
                       u.primer_idioma,
                       u.segundo_idioma,
                       r.id_rol, r.nombrerol,
                       u.status
                FROM usuarios u
                INNER JOIN rol r
                ON u.id_rol = r.id_rol
                WHERE u.id_usuario = $this->intIdUsuario";
        $request = $this->select($sql);
        $_SESSION['userData'] = $request;
        return $request;
    }

    public function getUserEmail(string $strEmail){

        $this->strUsuario = $strEmail;
        $sql = "SELECT id_usuario,nombres,apellidos,status FROM usuarios WHERE 
               email_user = '$this->strUsuario' and
               status = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function setTokenUser(int $id_usuario, string $token){
        $this->intIdUsuario = $id_usuario;
        $this->strToken = $token;
        $sql = "UPDATE usuarios SET token = ? WHERE id_usuario = $this->intIdUsuario";
        $arrData = array($this->strToken);
        $request = $this->update($sql,$arrData);
        return $request;

    }

    public function getUsuario(string $email, string $token){
        $this->strUsuario = $email;
        $this->strToken = $token;
        $sql = "SELECT id_usuario FROM usuarios WHERE
                email_user = '$this->strUsuario' and
                token = '$this->strToken' and
                status = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function insertPassword(int $id_usuario, string $password)
    {
        $this->intIdUsuario = $id_usuario;
        $this->strPassword = $password;
        $sql = "UPDATE usuarios SET password = ?, token = ? WHERE id_usuario = $this->intIdUsuario";
        $arrData = array($this->strPassword, ""); 
        $request = $this->update($sql, $arrData);
        return $request;
    }
    
    



}
?>
