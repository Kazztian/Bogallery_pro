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
            $this->views->getView($this, "categoria", $data);
            //vista Views
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
                    "subTotal" => SMONEY . formatMoney($subtotal),
                    "total" => SMONEY . formatMoney($subtotal + COSTOENVIO)
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
                empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || 
                empty($_POST['txtDireccion']) || empty($_POST['txtSegundoI']) || empty($_POST['txtEmailCliente']) || 
                empty($_POST['txtEdad']) || empty($_POST['txtPrimerI'])
            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $strNombre = ucwords(strClean($_POST['txtNombre']));
                $strApellido = ucwords(strClean($_POST['txtApellido']));
                $intTelefono = intval(strClean($_POST['txtTelefono']));
                $strDireccion = strtolower(strClean($_POST['txtDireccion']));
                $strSegundoI = ucwords(strClean($_POST['txtSegundoI']));
                $strEmail = strtolower(strClean($_POST['txtEmailCliente']));
                $intEdad = intval(strClean($_POST['txtEdad']));  // Asegurarse de que $intEdad sea un entero
                $strPrimerI = ucwords(strClean($_POST['txtPrimerI']));
                $intTipoId = 2;
    
                $request_user = "exist";
                $strPassword = passGenerator();
                $strPasswordEncript = hash("SHA256", $strPassword);
                $request_user = $this->insertCliente(
                    $strNombre,
                    $strApellido,
                    $intTelefono,
                    $strEmail,
                    $strPasswordEncript,
                    $intEdad,  // Asegurarse de pasar un entero aquí
                    $strDireccion,
                    $strPrimerI,
                    $strSegundoI,
                    $intTipoId
                );
    
                if ($request_user != "exist") {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    $nombreUsuario = $strNombre . ' ' . $strApellido;
                    $dataUsuario = array(
                        'nombreUsuario' => $nombreUsuario,
                        'email' => $strEmail,
                        'password' => $strPassword,
                        'asunto' => 'Bienvenido a BoGallery',
                    );
                    $_SESSION['idUser'] = $request_user;
                    $_SESSION['login'] = true;
                    $this->login->sessionLogin($request_user);
                    sendEmail($dataUsuario, 'email_bienvenida');
                } elseif ($request_user === "exist") {
                    $arrResponse = array('status' => false, 'msg' => '¡ATENCIÓN! El email ya existe.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
    
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
    
    public function procesarVenta()
    {
        if ($_POST) {
                $idtransaccionpaypal = NULL;
				$datospaypal = NULL;
				$idusuario = $_SESSION['idUser'];
				$monto = 0;
                $idtipopago = intval($_POST['inttipopago']);
				$direccionenvio = strClean($_POST['direccion']).', '.strClean($_POST['ciudad']);
				$status = "Pendiente";
				$subtotal = 0;
                $costo_iva = COSTOENVIO;

            if (!empty($_SESSION['arrCarrito'])) {
                foreach($_SESSION['arrCarrito'] as $pla){
                    $subtotal += $pla['cantidad'] * $pla['precio'];
                }
                $monto = formatMoney($subtotal + COSTOENVIO);
                //Proceso cuando se hace pago contraentrega

                if(empty($_POST['datapay'])){
                    $request_pedido = $this->insertPedido($idtransaccionpaypal,
                                                            $datospaypal,    
                                                            $idusuario,
                                                            $costo_iva,
                                                            $monto,
                                                            $idtipopago,
                                                            $direccionenvio,
                                                            $status
                                                            );

                        if($request_pedido > 0){
                        //Insertamos detalle
                        foreach ($_SESSION['arrCarrito'] as $plan) {
                        $idplan = $plan['id_plan'];
                        $precio = $plan['precio'];
                        $cantidad = $plan['cantidad'];
                        $this->insertDetalle($request_pedido,$idplan,$precio,$cantidad);
                        }
                        $infoOrden= $this->getPedidio($request_pedido);
                        $dataEmailOrden = array('asunto'=>"Se ha creado la inscripcion No.".$request_pedido,
                                        'email'=>$_SESSION['userData']['email_user'],
                                        'emailCopia'=>EMAIL_SUSCRIPCION,
                                        'pedido'=>$infoOrden);

                        sendEmail($dataEmailOrden,"email_notificacion_inscripcion");

                        $orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
                        $transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);
                        $arrResponse = array("status" => true,
                        "orden" => $orden,
                        "transaccion" => $transaccion,
                        "msg" => 'Plan realizado');	
                        $_SESSION['dataorden'] = $arrResponse;
                        //destruccion de la bariable de seccion carrito
                        unset($_SESSION['arrCarrito']);
                        session_regenerate_id(true);
                    }

                }else{
                    //Proceso cuando se hace el pago por paypal
                    $jsonPaypal = $_POST['datapay'];
                    $objPaypal = json_decode($jsonPaypal);
                    $status = "Aprobado";

                    if(is_object($objPaypal)){
                        $datospaypal = $jsonPaypal;
                        $idtransaccionpaypal = $objPaypal->purchase_units[0]->payments->captures[0]->id;

                        if($objPaypal->status == "COMPLETED"){
                            $totalPaypal = formatMoney($objPaypal->purchase_units[0]->amount->value);
                            if($monto == $totalPaypal){
                                $status = "Completo";
                            }
                            $request_pedido = $this->insertPedido($idtransaccionpaypal,
                                                                   $datospaypal,    
                                                                   $idusuario,
                                                                   $costo_iva,
                                                                    $monto,
                                                                    $idtipopago,
                                                                    $direccionenvio,
                                                                    $status
                                                                     );

                            if($request_pedido > 0){
                                	//Insertamos detalle
							foreach ($_SESSION['arrCarrito'] as $plan) {
								$idplan = $plan['id_plan'];
								$precio = $plan['precio'];
								$cantidad = $plan['cantidad'];
								$this->insertDetalle($request_pedido,$idplan,$precio,$cantidad);
							}
                            $infoOrden= $this->getPedidio($request_pedido);
                            $dataEmailOrden = array('asunto'=>"Se ha creado la inscripcion No.".$request_pedido,
                                            'email'=>$_SESSION['userData']['email_user'],
                                            'emailCopia'=>EMAIL_SUSCRIPCION,
                                            'pedido'=>$infoOrden);
    
                            sendEmail($dataEmailOrden,"email_notificacion_inscripcion");
                            $orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
							$transaccion = openssl_encrypt($idtransaccionpaypal, METHODENCRIPT, KEY);
							$arrResponse = array("status" => true,
                                          "orden" => $orden,
                                           "transaccion" => $transaccion,
                                            "msg" => 'Plan realizado');	
                            $_SESSION['dataorden'] = $arrResponse;
                            //destruccion de la bariable de seccion carrito
                            unset($_SESSION['arrCarrito']);
							session_regenerate_id(true);
                                
                            }else{
                                $arrResponse = array("status" => false, "msg" => 'No es posible procesar el plan');
        
                            }

                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No se ha podido completar el pago');
        
                        }


                    }else {
                        $arrResponse = array("status" => false, "msg" => 'Hubo un error en el proceso de pago');
        
                    }

                }

            }else{
                $arrResponse = array("status" => false, "msg" => 'No es posible procesar el plan');
        
            }


        } else {
            $arrResponse = array("status" => false, "msg" => 'No es posible procesar el plan');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function confirmarplan(){
        if(empty($_SESSION['dataorden'])){
            header("Location: ".base_url());
        }else{
            $dataorden = $_SESSION['dataorden'];
            $idpedido = openssl_decrypt($dataorden['orden'], METHODENCRIPT, KEY);
            $transaccion = openssl_encrypt($dataorden['transaccion'], METHODENCRIPT, KEY);
            $data['page_tag'] = "Confirmar Plan";
			$data['page_title'] = "Confirmar Plan";
			$data['page_name'] = "confirmarplan";
            $data['orden'] = $idpedido;
            $data['transaccion'] = $transaccion;
            $this->views->getView($this, "confirmarplan", $data);

        }
        //destruir variable de seccion
        unset($_SESSION['dataorden']);
    }
}
