
<?php

class Usuarios extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Usuarios()
    {
        $data['page_tag'] = "Usuarios";
        $data['page_title'] = "USUARIOS <small> Bogallery </small>";
        $data['page_name'] = "usuarios";

        $this->views->getView($this, "usuarios", $data);
    }

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
                $srtPrimerI = strClean($_POST['txtPrimerI']);
                $strSegundoI = strClean($_POST['txtSegundoI']);
                $intTipoId = intval(strClean($_POST['listRolid']));
                $intStatus = intval(strClean($_POST['listStatus']));

                if ($idUsuario == 0) {
                    $option = 1;
                    $strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtPassword']);

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
                } else {
                    $option = 2;
                    $strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);

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

                // Ajuste en la lógica de los condicionales para manejar las comparaciones correctamente
                if ($request_user !== "exist" && $request_user > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                    }
                } elseif ($request_user == "exist") {
                    $arrResponse = array('status' => false, 'msg' => '¡ATENCIÓN! El email o la identificación ya existe.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }


    public function getUsuarios()
    {
        $arrData = $this->model->selectUsuarios();

        // for para que se muestre el mensae correcto dependiendo del status, se recorre todo el array y llega a la posicion del status 
        for ($i = 0; $i < count($arrData); $i++) {

            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="me-1 badge bg-success" style="display: inline-block; font-size: 0.9rem;">Activo</span>';
            } else {
                $arrData[$i]['status'] = '<span class="me-1 badge bg-danger"style="display: inline-block; font-size: 0.9rem;">Inactivo</span>';
            }
            $arrData[$i]['options'] = '<div class="text-center">
                   <button class="btn btn-outline-info btn-sm btnViewUsuario" onClick="ftnbViewUsuario(' . $arrData[$i]['id_usuario'] . ')" title="Ver Usuario"><i class="bi bi-eye-fill"></i></button>

                <button class="btn btn-warning btn-sm btnEditUsuario"  onClick="fntEditUsuario(' . $arrData[$i]['id_usuario'] . ')" title="Editar Usuario"><i class="bi bi-pencil-square"></i></button>

                <button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario(' . $arrData[$i]['id_usuario'] . ')" title="Eliminar"><i class="bi bi-trash"></i></button>
                </div>';
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE); //Formato json para que pueda ser interpretado por cualquier lenguaje(Se convierta en un objeto)
        die();  //Finaliza el proceso
    }
    public function getUsuario(int $id_usuario)
    {
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
        die();
    }

    public function delUsuario()
    {
        if ($_POST) {
            $intIdUsuario = intval($_POST['idUsuario']);
            $requestDelete = $this->model->deleteUsuario($intIdUsuario);
            
            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario');
            }
            
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    
}
