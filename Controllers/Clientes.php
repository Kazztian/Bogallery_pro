<?php

class Clientes extends Controllers
{
    public function __construct()

    {
        //sessionStart();
        // codigo que permite que funcione correctamente si no esta logiado
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        getPermisos(3);
    }

    public function Clientes()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Clientes";
        $data['page_title'] = "CLIENTES <small> Bogallery </small>";
        $data['page_name'] = "clientes";
        $data['page_functions_js'] = "functions_clientes.js";
        $this->views->getView($this, "clientes", $data);
    }

    public function setCliente()
    {
        if ($_POST) {

            if (
                empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) ||
                empty($_POST['txtEdad']) || empty($_POST['txtDireccion']) || empty($_POST['txtPrimerI']) || empty($_POST['txtSegundoI']) ||
                empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal'])
            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idUsuario = intval($_POST['id_usuario']);
                $strNombre = ucwords(strClean($_POST['txtNombre']));
                $strApellido = ucwords(strClean($_POST['txtApellido']));
                $intTelefono = intval(strClean($_POST['txtTelefono']));
                $strEmail = strtolower(strClean($_POST['txtEmail']));
                $intEdad = intval(strClean($_POST['txtEdad']));
                $strDireccion = strClean($_POST['txtDireccion']);
                $srtPrimerI = ucwords(strClean($_POST['txtPrimerI']));
                $strSegundoI = ucwords(strClean($_POST['txtSegundoI']));
                $strNit = strClean($_POST['txtNit']);
                $strNomFiscal = strClean($_POST['txtNombreFiscal']);
                $strDirFiscal = strClean($_POST['txtDirFiscal']);
                $intTipoId = 2;

                $request_user = "exist";
                //Se crea las variables que van almacenar los datos en las lineas de arriba

                //Validacion para generar contraseña si el usuario no tiene una, hash lo que hace es encriptar
                if ($idUsuario == 0) {
                    $option = 1;
                    $strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtPassword']);

                    if ($_SESSION['permisosMod']['w']) {
                        // Llamada al modelo con los parámetros corregidos
                        $request_user = $this->model->insertCliente(
                            $strNombre,
                            $strApellido,
                            $intTelefono,
                            $strEmail,
                            $strPassword, // Faltaba este argumento
                            $intEdad,
                            $strDireccion,
                            $srtPrimerI,
                            $strSegundoI,
                            $intTipoId,
                            $strNit,
                            $strNomFiscal,
                            $strDirFiscal
                        );
                    }
                } else {
                    /*$option = 2;
                    $strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);

                    if ($_SESSION['permisosMod']['u']) {
                    // Llamada al modelo con los parámetros corregidos
                    $request_user = $this->model->updateCliente(
                        $idUsuario,
                        $strNombre,
                        $strApellido,
                        $intTelefono,
                        $strEmail,
                        $strPassword, // Faltaba este argumento
                        $intEdad,
                        $strDireccion,
                        $srtPrimerI,
                        $strSegundoI,
                        $strNit,
                        $strNomFiscal,
                        $strDirFiscal
                    );
                }*/
                }
                // Ajuste en la lógica de los condicionales para manejar las comparaciones correctamente
                if ($request_user  != "exist") {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');

                        //$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                    }
                } elseif ($request_user === "exist") {
                    $arrResponse = array('status' => false, 'msg' => '¡ATENCIÓN! El email o la identificación ya existe.');
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
