
<?php

class Usuarios extends Controllers
{
    public function __construct()

    {
        sessionStart();
        // codigo que permite que funcione correctamente si no esta logiado
        parent::__construct();
        //session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(2);
    }

    public function Usuarios()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Usuarios";
        $data['page_title'] = "USUARIOS <small> Bogallery </small>";
        $data['page_name'] = "usuarios";
        $data['page_functions_js'] = "functions_usuarios.js";
        $this->views->getView($this, "usuarios", $data);
    }
    /* Metodo para enviar los datos a la ruta de setUsuario en 
function_usuario donde de busca este archivo y este metodo
empty= Verifica si esta vacio algun campo*/
    public function setUsuario()
    {
        if ($_POST) {

            if (
                empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) ||
                empty($_POST['txtEdad']) || empty($_POST['txtDireccion']) || empty($_POST['txtPrimerI']) || empty($_POST['txtSegundoI']) ||
                empty($_POST['listRolid']) || empty($_POST['listStatus'])
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
                $intTipoId = intval(strClean($_POST['listRolid']));
                $intStatus = intval(strClean($_POST['listStatus']));

                $request_user = "exist";
                //Se crea las variables que van almacenar los datos en las lineas de arriba

                //Validacion para generar contraseña si el usuario no tiene una, hash lo que hace es encriptar
                if ($idUsuario == 0) {
                    $option = 1;
                    $strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtPassword']);

                    if ($_SESSION['permisosMod']['w']) {
                        // Llamada al modelo con los parámetros corregidos
                        $request_user = $this->model->insertUsuario(
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
                            $intStatus
                        );
                    }
                } else {
                    $option = 2;
                    $strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);

                    if ($_SESSION['permisosMod']['u']) {
                    // Llamada al modelo con los parámetros corregidos
                    $request_user = $this->model->updateUsuario(
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
                        $intTipoId,
                        $intStatus
                    );
                }
            }
                // Ajuste en la lógica de los condicionales para manejar las comparaciones correctamente
                if ($request_user != "exist") {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');

                        // $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
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
    //Metodo para invocar lo que se hizo en selectUsuarios en el ModelUsuario
    public function getUsuarios()
    {

        if ($_SESSION['permisosMod']['r']) {


            $arrData = $this->model->selectUsuarios();

            // for para que se muestre el mensae correcto dependiendo del status, se recorre todo el array y llega a la posicion del status 
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = "";
                $btnEdit = "";
                $btnDelete = "";

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="me-1 badge bg-success" style="display: inline-block; font-size: 0.9rem;">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="me-1 badge bg-danger"style="display: inline-block; font-size: 0.9rem;">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = ' <button class="btn btn-outline-info btn-sm btnViewUsuario" onClick="ftnbViewUsuario(' . $arrData[$i]['id_usuario'] . ')" title="Ver Usuario"><i class="bi bi-eye-fill"></i></button>';
                }

                if ($_SESSION['permisosMod']['u']) {
                    if (($_SESSION['idUser'] == 1 && $_SESSION['userData']['id_rol'] == 1) ||
                        ($_SESSION['userData']['id_rol'] == 1 && $arrData[$i]['id_rol'] != 1)
                    ) {
                        $btnEdit = ' <button class="btn btn-warning btn-sm btnEditUsuario"  onClick="fntEditUsuario(this,' . $arrData[$i]['id_usuario'] . ')" title="Editar Usuario"><i class="bi bi-pencil-square"></i></button>';
                    } else {
                        $btnEdit = ' <button class="btn btn-warning btn-sm btnEditUsuario" disabled ><i class="bi bi-pencil-square"></i></button>';
                    }
                }

                if ($_SESSION['permisosMod']['d']) {
                    if (($_SESSION['idUser'] == 1 and $_SESSION['userData']['id_rol'] == 1) ||
                        ($_SESSION['userData']['id_rol'] == 1 and $arrData[$i]['id_rol'] != 1) and
                        ($_SESSION['userData']['id_usuario'] != $arrData[$i]['id_usuario'])
                    ) {
                        $btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario(' . $arrData[$i]['id_usuario'] . ')" title="Eliminar"><i class="bi bi-trash"></i></button>';
                    } else {
                        $btnDelete = '<button class="btn btn-danger btn-sm" disabled><i class="bi bi-trash"></i></button>';
                    }
                }
                $arrData[$i]['options'] = '<div class="text-center"> ' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . ' </div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE); //Formato json para que pueda ser interpretado por cualquier lenguaje(Se convierta en un objeto)
        }
        die();  //Finaliza el proceso
    }
    /*Metodo que extrae los datos de un usuario el cual esta 
    conectado con fuction Usuarios*/
    public function getUsuario($id_usuario)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idusuario = intval($id_usuario);
            if ($idusuario > 0) {
                $arrData = $this->model->selectUsuario($idusuario);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    //Metodo para eliminar un usuario
    public function delUsuario()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
            $intIdUsuario = intval($_POST['idUsuario']);
            $requestDelete = $this->model->deleteUsuario($intIdUsuario);

            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario');
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        }
        die();
    }
    public function perfil()
    {

        $data['page_tag'] = "Perfil";
        $data['page_title'] = "Perfil de usuario";
        $data['page_name'] = "perfil";
        $data['page_functions_js'] = "functions_usuarios.js";
        $this->views->getView($this, "perfil", $data);
    }
    public function putPerfil()
    {
        if ($_POST) {
            if (
                empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEdad']) || empty($_POST['txtDireccion'])
                || empty($_POST['txtPrimerI']) || empty($_POST['txtSegundoI'])
            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idUsuario = $_SESSION['idUser'];

                $strNombre = strClean($_POST['txtNombre']);
                $strApellido = strClean($_POST['txtApellido']);
                $intTelefono = intval(strClean($_POST['txtTelefono']));
                $intEdad = intval(strClean($_POST['txtEdad']));
                $strDireccion = strClean($_POST['txtDireccion']);
                $srtPrimerI = ucwords(strClean($_POST['txtPrimerI']));
                $strSegundoI = ucwords(strClean($_POST['txtSegundoI']));
                $strPassword = "";
                if (!empty($_POST['txtPassword'])) {
                    $strPassword = hash("SHA256", $_POST['txtPassword']);
                }
                $request_user = $this->model->updatePerfil(
                    $idUsuario,
                    $strNombre,
                    $strApellido,
                    $intTelefono,
                    $strPassword,
                    $intEdad,
                    $strDireccion,
                    $srtPrimerI,
                    $strSegundoI
                );
                if ($request_user) {
                    sessionUser($_SESSION['idUser']);
                    $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
                }
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function putDfiscal()
    {
        if ($_POST) {
            if (empty($_POST['txtNit']) || empty($_POST['txtNombreFiscal']) || empty($_POST['txtDirFiscal'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idUsuario = $_SESSION['idUser'];
                $strNit = strClean($_POST['txtNit']);
                $strNomFiscal = strClean($_POST['txtNombreFiscal']);
                $strDirFiscal = strClean($_POST['txtDirFiscal']);
                $request_datafiscal = $this->model->updateDataFiscal(
                    $idUsuario,
                    $strNit,
                    $strNomFiscal,
                    $strDirFiscal
                );
                if ($request_datafiscal) {
                    sessionUser($_SESSION['idUser']);
                    $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
                }
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
?>