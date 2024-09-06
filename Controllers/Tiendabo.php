
<?php
// Requerir los archivos trie donde se extrae la info 
require_once("Models/TCategoria.php");
require_once("Models/TPlan.php");
require_once("Models/TCliente.php");
require_once("Models/LoginModel.php");
class Tiendabo extends Controllers
{
    use TCategoria, TPlan, TCliente; //Usar los trait
    public $login;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->login = new LoginModel;
    }
    // esto extre todo los planes cuando se diriga a planes
    public function tiendabo()
    {
        $data['page_tag'] = NOMBRE_EMPRESA;
        $data['page_title'] = NOMBRE_EMPRESA;
        $data['page_name'] = "tiendabo";
        $data['planes'] = $this->getPlanesT();
        $this->views->getView($this, "tiendabo", $data);
    }
    // Esta parte extrae los planes filtrador por categorias

    public function categoria($params)
    {
        if (empty($params)) {
            header("Location:" . base_url());
        } else {
            $arrParams = explode(",", $params);
            $idCategoria = intval($arrParams[0]);
            $ruta = strClean($arrParams[1]);
            $infoCategoria = $this->getPlanesCategoriaT($idCategoria, $ruta);
            $categoria = strClean($params);
            $data['page_tag'] = NOMBRE_EMPRESA . " - " .  $infoCategoria['categoria'];
            $data['page_title'] =  $infoCategoria['categoria'];
            $data['page_name'] = "categoria";
            $data['planes'] = $infoCategoria['planes'];
            $this->views->getView($this, "categoria", $data); //vista Views
        }
    }

    public function plan($params)
    {
        if (empty($params)) {
            header("Location:" . base_url());
        } else {
            $arrParams = explode(",", $params);
            $idplan = intval($arrParams[0]);
            $ruta = strClean($arrParams[1]);
            $infoPlan = $this->getPlanT($idplan, $ruta);
            if (empty($infoPlan)) {
                header("Location:" . base_url());
            }
            $data['page_tag'] = NOMBRE_EMPRESA . " - " . $infoPlan['nombre'];
            $data['page_title'] = $infoPlan['nombre'];
            $data['page_name'] = "plan";
            $data['plan'] = $infoPlan;
            $data['planes'] = $this->getPlanesRandom($infoPlan['id_categoria'], 8, "r");
            $this->views->getView($this, "plan", $data);
        }
    }

    public function addCarrito()
    {
        if ($_POST) {
            //  unset($_SESSION['arrCarrito']); exit;
            $arrCarrito = array();
            $cantCarrito = 0;
            $idplan = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
            $cantidad = $_POST['cant'];
            if (is_numeric($idplan) and is_numeric($cantidad)) {
                $arrInfoPlan = $this->getPlanIDT($idplan);
                if (!empty($arrInfoPlan)) {
                    $arrPlan = array(
                        'id_plan' => $idplan,
                        'plan' => $arrInfoPlan['nombre'],
                        'cantidad' => $cantidad,
                        'precio' => $arrInfoPlan['precio'],
                        'imagen' => $arrInfoPlan['images'][0]['url_image']
                    );
                    if (isset($_SESSION['arrCarrito'])) {
                        $on = true;
                        $arrCarrito = $_SESSION['arrCarrito'];
                        for ($pl = 0; $pl < count($arrCarrito); $pl++) {
                            if ($arrCarrito[$pl]['id_plan'] == $idplan) {
                                $arrCarrito[$pl]['cantidad'] += $cantidad;
                                $on = false;
                            }
                        }
                        if ($on) {
                            array_push($arrCarrito, $arrPlan);
                        }
                        $_SESSION['arrCarrito'] = $arrCarrito;
                    } else {
                        array_push($arrCarrito, $arrPlan);
                        $_SESSION['arrCarrito'] = $arrCarrito;
                    }
                    foreach ($_SESSION['arrCarrito'] as $pla) {
                        $cantCarrito += $pla['cantidad'];
                    }
                    $htmlCarrito = getFile('Template/Modals/modalCarrito', $_SESSION['arrCarrito']);
                    $arrResponse = array(
                        "status" => true,
                        "msg" => '¡Se agrego al carrito!',
                        "cantCarrito" => $cantCarrito,
                        "htmlCarrito" => $htmlCarrito
                    );
                } else {
                    $arrResponse = array("status" => false, "msg" => 'Plan no encontrado.');
                }
            } else {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delCarrito()
    {
        if ($_POST) {
            $arrCarrito = array();
            $cantCarrito = 0;
            $subtotal = 0;
            $idplan = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
            $option = $_POST['option'];
            if (is_numeric($idplan) and ($option == 1 or $option == 2)) {
                $arrCarrito = $_SESSION['arrCarrito'];
                for ($pl = 0; $pl < count($arrCarrito); $pl++) {
                    if ($arrCarrito[$pl]['id_plan'] == $idplan) {
                        unset($arrCarrito[$pl]);
                    }
                }

                sort($arrCarrito);
                $_SESSION['arrCarrito'] = $arrCarrito;
                foreach ($_SESSION['arrCarrito'] as $pla) {
                    $cantCarrito += $pla['cantidad'];
                    $subtotal += $pla['cantidad'] * $pla['precio'];
                }
                $htmlCarrito = "";
                if ($option == 1) {
                    $htmlCarrito = getFile('Template/Modals/modalCarrito', $_SESSION['arrCarrito']);
                }
                $arrResponse = array(
                    "status" => true,
                    "msg" => '¡Se elimino el plan!',
                    "cantCarrito" => $cantCarrito,
                    "htmlCarrito" => $htmlCarrito,
                    "subTotal" => SMONEY.formatMoney($subtotal),
                    "total" => SMONEY.formatMoney($subtotal + COSTOENVIO)
                );
            } else {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }


    public function updCarrito()
{
    if ($_POST) {
        $arrCarrito = array();
        $totalPlan = 0;
        $subtotal = 0;
        $total = 0;           
        $idplan = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
        $cantidad = intval($_POST['cantidad']);
        
        if (is_numeric($idplan) && $cantidad > 0) {
            $arrCarrito = $_SESSION['arrCarrito'];
            
            // Actualización del plan en el carrito
            for ($p = 0; $p < count($arrCarrito); $p++) {
                if ($arrCarrito[$p]['id_plan'] == $idplan) {
                    $arrCarrito[$p]['cantidad'] = $cantidad;
                    $totalPlan = $arrCarrito[$p]['precio'] * $cantidad; // Corregido el cálculo
                    break;
                }
            }

            $_SESSION['arrCarrito'] = $arrCarrito;

            // Cálculo del subtotal
            foreach ($_SESSION['arrCarrito'] as $pla) {
                $subtotal += $pla['cantidad'] * $pla['precio'];
            }

            // Formateo de los valores de precios (evitar errores con SMONEY y formatMoney)
            $arrResponse = array(
                "status" => true,
                "msg" => '¡Plan Actualizado!',
                "totalPlan" => SMONEY . formatMoney($totalPlan), // Asegúrate que SMONEY y formatMoney estén bien
                "subTotal" => SMONEY . formatMoney($subtotal),
                "total" => SMONEY . formatMoney($subtotal + COSTOENVIO) 
            );

        } else {
            $arrResponse = array("status" => false, "msg" => 'Datos incorrectos');
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }
    die();
}

public function registro()
    {
        if ($_POST) {

            if (
                empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmailCliente']) ||
                empty($_POST['txtEdad']) || empty($_POST['txtPrimerI']) )
                 {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
      
                $strNombre = ucwords(strClean($_POST['txtNombre']));
                $strApellido = ucwords(strClean($_POST['txtApellido']));
                $intTelefono = intval(strClean($_POST['txtTelefono']));
                $strEmail = strtolower(strClean($_POST['txtEmailCliente']));
                $intEdad = intval(strClean($_POST['txtEdad']));
                $srtPrimerI = ucwords(strClean($_POST['txtPrimerI']));
                $intTipoId = 2;

                $request_user = "exist";
                $strPassword =  passGenerator();
                $srtPasswordEncript =  hash("SHA256", $strPassword);
                $request_user = $this->insertCliente($strNombre,
                        $strApellido,
                        $intTelefono,
                        $strEmail,
                        $srtPasswordEncript, // Faltaba este argumento
                        $intEdad,
                        $srtPrimerI,
                        $intTipoId);
                
                // Ajuste en la lógica de los condicionales para manejar las comparaciones correctamente
                if ($request_user  != "exist")
                 {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    $nombreUsuario = $strNombre .''. $strApellido;
                    $dataUsuario = array('nombreUsuario' => $nombreUsuario,
                            'email' => $strEmail,
                            'password' => $strPassword,
                            'asunto' => 'Bienvenido a BoGallery',
                        );
                        $_SESSION['idUser'] = $request_user;
                        $_SESSION['login'] = true;
                        $this->login->sessionLogin($request_user);
                       // sendEmail($dataUsuario, 'email_bienvenida');
                    
                } elseif ($request_user === "exist") {
                    $arrResponse = array('status' => false, 'msg' => '¡ATENCIÓN! El email ya existe.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');

                    // $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                }

                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }

}

?>