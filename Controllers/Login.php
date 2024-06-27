<?php

class Login extends Controllers
{
    public function __construct()
    {
        session_start();
        if(isset($_SESSION['login']))
        {
            header('Location: '.base_url().'/dashboard');
        }
        parent::__construct();
    }

    public function login()
    {
        $data['page_tag'] = "Login - BoGallery";
        $data['page_title'] = "Login - BoGallery";
        $data['page_name'] = "login";
        $data['page_functions_js'] = "functions_login.js";
        $this->views->getView($this, "login",$data);
    }

    public function loginUser()
    {
        if ($_POST) {
            if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $strUsuario = strtolower(strClean($_POST['txtEmail']));
                $strPassword = hash("SHA256", $_POST['txtPassword']);
                $requestUser = $this->model->loginUser($strUsuario, $strPassword);
                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecta');
                } else {
                    $arrData = $requestUser;
                    if ($arrData['status'] == 1) {
                        $_SESSION['idUser'] = $arrData['id_usuario'];
                        $_SESSION['login'] = true;
                        // Almacena los datos (mejor experiencia para el usuario)
                        $arrData = $this->model->sessionLogin($_SESSION['idUser']);
                        $_SESSION['userData'] = $arrData;

                        $arrResponse = array('status' => true, 'msg' => 'ok');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'Usuario Inactivo');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
    public function resetPass()
    {
        if ($_POST) {
            error_reporting(0);
        
            if (empty($_POST['txtEmailReset'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $token = token();
                $strEmail = strtolower(strClean($_POST['txtEmailReset']));
                $arrData = $this->model->getUserEmail($strEmail);

                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Usuario no existente');
                } else {
                    $id_usuario = $arrData['id_usuario'];
                    $nombreUsuario = $arrData['nombres'] . ' ' . $arrData['apellidos'];

                    $url_recovery = base_url() . '/login/confirmUser/' . $strEmail . '/' . $token;
                    $requestUpdate = $this->model->setTokenUser($id_usuario, $token);

                    $dataUsuario = array('nombreUsuario'=>$nombreUsuario,
                                          'email'=>$strEmail,
                                          'asunto'=>'Recuperar Cuenta-'.NOMBRE_REMITENTE,
                                          'url_recovery'=>$url_recovery);

                    if ($requestUpdate) {
                                              
                        $sendEmail= sendEmail($dataUsuario,'email_cambioPassword');
                        if($sendEmail){
                            $arrResponse = array('status' => true, 'msg' => 'Se ha enviado un correo electrónico a tu cuenta para restablecer tu contraseña.');

                        }else{
                            $arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso. Intenta más tarde.');

                        }
                      
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso. Intenta más tarde.');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }


    public function confirmUser(string $params){

        if(empty($params)){
            header('Location:'.base_url());
        }else{
            $arrParams = explode(',',$params);
            $strEmail = strClean($arrParams[0]);
            $strToken = strClean($arrParams[1]);

          $arrResponse = $this->model->getUsuario($strEmail,$strToken);
          if(empty($arrResponse)){
            header("Location:".base_url());
          }else{
                $data['page_tag'] = "Cambiar contraseña";
                $data['page_name'] = "cambiar_contraseña";
                $data['page_title'] = "Cambiar contraseña";
                $data['email'] = $strEmail ;
                $data['token'] =  $strToken;
                $data['id_usuario'] = $arrResponse['id_usuario'];
                $data['page_functions_js'] = "functions_login.js";
                $this->views->getView($this, "cambiar_password",$data);
          }
        }
        die();

    }
    public function setPassword()
{
    if ($_POST) {
        if (empty($_POST['id_usuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm'])) {
            $arrResponse = array('status' => false, 'msg' => 'Error de datos');
        } else {
            $intIdUsuario = intval($_POST['id_usuario']);
            $strPassword = $_POST['txtPassword'];
            $strPasswordConfirm = $_POST['txtPasswordConfirm'];
            $strEmail = strClean($_POST['txtEmail']);
            $strToken = strClean($_POST['txtToken']);

            if ($strPassword != $strPasswordConfirm) {
                $arrResponse = array('status' => false, 'msg' => 'Las contraseñas no son iguales');
            } else {
                $arrResponseUser = $this->model->getUsuario($strEmail, $strToken);
                if (empty($arrResponseUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'Error de datos.');
                } else {
                    $strPassword = hash("SHA256", $strPassword); // Encriptamos
                    $requestPass = $this->model->insertPassword($intIdUsuario, $strPassword);

                    if ($requestPass) {
                        $arrResponse = array('status' => true, 'msg' => 'Contraseña actualizada con éxito');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intente más tarde');
                    }
                }
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }
    die();
}

}
?>
