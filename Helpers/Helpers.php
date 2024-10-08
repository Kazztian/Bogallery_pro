<?php

//Libreria e implementacion de envio de correo de forma local
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Libraries/phpmailer/Exception.php';
require 'Libraries/phpmailer/PHPMailer.php';
require 'Libraries/phpmailer/SMTP.php';

//Retorna la URL del proyecto
function base_url()
{
    return BASE_URL;
}

//Retorna la ruta de Assets y lo que contenga
function media()
{
    return BASE_URL . "/Assets";
}
//Funcines para que se muestren las partes completas del templateAdmin  en cada seccion que hagamos
function headerAdmin($data = "")
{
    $view_header = "Views/Template/header_admin.php";
    require_once($view_header);
}

function footerAdmin($data = "")
{
    $view_footer = "Views/Template/footer_admin.php";
    require_once($view_footer);
}

//Funcines para que se muestren las partes completas del templeteTiedaBo en cada seccion que hagamos
function headerTiendabo($data = "")
{
    $view_header = "Views/Template/header_tiendaBo.php";
    require_once($view_header);
}

function footerTiendabo($data="")
{
    $view_footer = "Views/Template/footer_tiendaBo.php";
    require_once($view_footer);
}

//Muestra la informacion formateada o mas lejible
function dep($data)
{
    $format  = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}


//Funcion para el formulario de roles 
function getModal(string $nameModal, $data)
{

    $view_modal = "Views/Template/Modals/{$nameModal}.php";
    require_once $view_modal;
}
//Funcion obtener las rutas del carrito
function getFile(string $url, $data){
    ob_start();
    require_once("Views/{$url}.php");
    $file = ob_get_clean(); 
    return $file;
}
//Envio de correos
function sendEmail($data, $template)
{
    if(ENVIRONMENT == 1) {
    $asunto = $data['asunto'];
    $emailDestino = $data['email'];
    $empresa = NOMBRE_REMITENTE;
    $remitente = EMAIL_REMITENTE;
    $emailCopia = !empty($data['emailCopia']) ? $data['emailCopia'] : "";

    //ENVIO DE CORREO
    $de = "MIME-Version: 1.0 \r\n";
    $de .= "Content-type:text/html; charset=UTF-8\r\n";
    $de .= "From: {$empresa}<{$remitente}>\r\n";
    $de .= "Bcc: $emailCopia\r\n";
    ob_start();
    require_once("Views/Template/Email/" . $template . ".php");
    $mensaje = ob_get_clean();
    $send = mail($emailDestino, $asunto, $mensaje, $de);
    return $send;
    } else {

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        ob_start();
        require_once("Views/Template/Email/" . $template . ".php");
        $mensaje = ob_get_clean();

        try {
            //Server settings
            $mail->SMTPDebug = 0;                                   //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'bogallerygaes@gmail.com';                     //SMTP username
            $mail->Password   = 'ncicbxovdjczlhyc';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('bogallerygaes@gmail.com', 'Servidor Local');
            $mail->addAddress($data['email']);     //Add a recipient 
            if (!empty($data['emailCopia'])) {
                $mail->addBCC($data['emailCopia']);
            }
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $data['asunto'];
            $mail->Body    = $mensaje;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

function sendMailLocal($data, $template)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    ob_start();
    require_once("Views/Template/Email/" . $template . ".php");
    $mensaje = ob_get_clean();
    try {
        //Server settings
        $mail->SMTPDebug = 1;                                   //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'bogallerygaes@gmail.com';                     //SMTP username
        $mail->Password   = 'ncicbxovdjczlhyc';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('bogallerygaes@gmail.com', 'Servidor Local');
        $mail->addAddress($data['email']);     //Add a recipient 
        if (!empty($data['emailCopia'])) {
            $mail->addBCC($data['emailCopia']);
        }   
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $data['asunto'];
        $mail->Body    = $mensaje;

        $mail->send();
        echo 'Mensaje enviado correctamente';
    } catch (Exception $e) {
        echo "Error en el envio del mensaje: {$mail->ErrorInfo}";
    }
}

function getPermisos(int $id_modulo)
{
    require_once("Models/PermisosModel.php");
    $objPermisos = new PermisosModel();
    if(!empty($_SESSION['userData'])){
    $idrol = $_SESSION['userData']['id_rol'];
    $arrPermisos = $objPermisos->permisosModulo($idrol);
    $permisos = '';
    $permisosMod = '';

    if (count($arrPermisos) > 0) {
        $permisos = $arrPermisos;
        $permisosMod = isset($arrPermisos[$id_modulo]) ?  $arrPermisos[$id_modulo] : '';
    }

    $_SESSION['permisos'] = $permisos;
    $_SESSION['permisosMod'] = $permisosMod;
}
}

function sessionUser(int $idusuario)
{
    require_once("Models/LoginModel.php");
    $objLogin = new LoginModel();
    $request = $objLogin->sessionLogin($idusuario);
    return $request;
}

function uploadImage(array $data, string $name){
    $url_temp = $data['tmp_name'];
    $destino    = 'Assets/images/uploads/'.$name;        
    $move = move_uploaded_file($url_temp, $destino);
    return $move;
}

function deleteFile(string $name){
    unlink('Assets/images/uploads/'.$name);
}

function sessionStart()
{
    session_start();
    $inactive = 1800;
    if (isset($_SESSION['timeout'])) {
        $session_in = time() - $_SESSION['inicio'];
        if ($session_in > $inactive) {
            header("Location: " . BASE_URL . "/logout");
        }
    } else {
        header("Location: " . BASE_URL . "/logout");
    }
}


//Elimina el exceso de espacios entre palabras
function strClean($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ diagonales invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}

function clear_cadena(string $cadena)
{
    //Reemplazamos la A y a
    $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena
    );

    //Reemplazamos la I y i
    $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena
    );

    //Reemplazamos la O y o
    $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena
    );

    //Reemplazamos la U y u
    $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena
    );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç', ',', '.', ';', ':'),
        array('N', 'n', 'C', 'c', '', '', '', ''),
        $cadena
    );
    return $cadena;
}
//Genera una contraseña de 10 caracteres
function passGenerator($length = 10)
{
    $pass = "";
    $longitudPass = $length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);

    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}
//Generador de token para restablecer contraseña

function token()
{
    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;

    return $token;
}

function formatMoney($cantidad)
{
    $cantidad = number_format($cantidad, 2, SPD, SPM);
    return $cantidad;
}
//Funcion para retornar el token
function getTokenPaypal() {
    // Inicializar cURL
    $payLogin = curl_init(URLPAYPAL."/v1/oauth2/token");
    // Configuración de cURL
    curl_setopt($payLogin, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt($payLogin, CURLOPT_RETURNTRANSFER, TRUE);   
    curl_setopt($payLogin, CURLOPT_USERPWD, IDCLIENTE . ":" . SECRET);  // Autenticación con Client ID y Secret
    curl_setopt($payLogin, CURLOPT_POSTFIELDS, "grant_type=client_credentials");  // Tipo de credencial
    // Ejecutar cURL y capturar el resultado
    $result = curl_exec($payLogin);
    $err = curl_error($payLogin);
    curl_close($payLogin);
    if($err){
        $request = "CURL Error #:".$err;
    }else{

        $objData = json_decode($result);
        $request=$objData->access_token;
    }
    return $request;
}
// Funcio para peticiones tipo Get
function CurlConnectionGet(string $ruta, string $contentType =null, string $token){
    $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
    if($token != null){
        $arrHeader = array('Content-Type:'.$content_type,
                        'Authorization: Bearer '.$token);
    }else{
        $arrHeader = array('Content-Type:'.$content_type);
                    
    }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$ruta);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err){
            $request = "CURL Error #:".$err;
        }else{
    
            $request = json_decode($result);    
        }
        return $request;
}
// Funcio para peticiones tipo Post
function CurlConnectionPost(string $ruta, string $contentType =null, string $token){
    $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
    if($token != null){
        $arrHeader = array('Content-Type:'.$content_type,
                        'Authorization: Bearer '.$token);
    }else{
        $arrHeader = array('Content-Type:'.$content_type);
                    
    }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$ruta);
        curl_setopt($ch, CURLOPT_POST,TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err){
            $request = "CURL Error #:".$err;
        }else{
    
            $request = json_decode($result);    
        }
        return $request;
}


?>