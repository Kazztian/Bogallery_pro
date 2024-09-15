<?php
class Planes extends Controllers
{
    public function __construct()

    {
        parent::__construct();
        session_Start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(7);
    }

    public function Planes()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Planes";
        $data['page_title'] = "PLANES <small>BoGallery</small>";
        $data['page_name'] = "planes";
        $data['page_functions_js'] = "functions_planes.js";
        $this->views->getView($this, "planes", $data);
    }

    public function getPlanes()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectPlanes();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                $arrData[$i]['precio'] = SMONEY . ' ' . formatMoney($arrData[$i]['precio']);


                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id_plan'] . ')" title="Ver Plan"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id_plan'] . ')" title="Editar Plan"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id_plan'] . ')" title="Eliminar Plan"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setPlanes()
    {
        if ($_POST) {
            // Validar los datos enviados
            if (empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria']) || empty($_POST['listLugar']) || empty($_POST['txtPrecio']) || empty($_POST['listStatus']) || empty($_POST['Jornadap']) || empty($_POST['fechaInicio']) || empty($_POST['fechaFin'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idPlan = intval($_POST['idPlanes']);
                $strNombre = strClean($_POST['txtNombre']);
                $strDescripcion = strClean($_POST['txtDescripcion']);
                $strCodigo = strClean($_POST['txtCodigo']);
                $intIdCategoria = intval($_POST['listCategoria']);
                $intIdLugar = intval($_POST['listLugar']);
                $strPrecio = strClean($_POST['txtPrecio']);
                $intStock = intval($_POST['txtStock']);
                $intStatus = intval($_POST['listStatus']);
                $strJornadap = strClean($_POST['Jornadap']); // Campo de la jornada
                $fechaInicio = strClean($_POST['fechaInicio']);
                $fechaFin = strClean($_POST['fechaFin']);

                $request_planes = "";

                $ruta = strtolower(clear_cadena($strNombre));
                $ruta = str_replace(" ", "-", $ruta);

                // Verificar si se trata de una inserción o actualización
                if ($idPlan == 0) {
                    // Inserción
                    if ($_SESSION['permisosMod']['w']) {
                        // Verificar si el código ya existe
                        $existingCode = $this->model->checkCodeExists($strCodigo);
                        if ($existingCode) {
                            $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el Código Ingresado.');
                        } else {
                            // Inserción
                            $request_planes = $this->model->insertPlanes(
                                $strNombre,
                                $strDescripcion,
                                $strCodigo,
                                $intIdCategoria,
                                $intIdLugar,
                                $strPrecio,
                                $intStock,
                                $ruta,
                                $intStatus,
                                $strJornadap, // Guardar jornada
                                $fechaInicio,  // Guardar fecha de inicio
                                $fechaFin    // Guardar fecha de fin

                            );
                            if ($request_planes > 0) {
                                $arrResponse = array('status' => true, 'idplan' => $request_planes, 'msg' => 'Datos guardados correctamente.');
                            } else {
                                $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                            }
                        }
                    }
                } else {
                    // Actualización
                    if ($_SESSION['permisosMod']['u']) {
                        // Verificar si el código ya existe en otro plan
                        $existingCode = $this->model->checkCodeExists($strCodigo, $idPlan);
                        if ($existingCode) {
                            $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el Código Ingresado.');
                        } else {
                            // Actualización
                            $request_planes = $this->model->updatePlanes(
                                $idPlan,
                                $strNombre,
                                $strDescripcion,
                                $strCodigo,
                                $intIdCategoria,
                                $intIdLugar,
                                $strPrecio,
                                $intStock,
                                $ruta,
                                $intStatus,
                                $strJornadap,    // Actualizar jornada
                                $fechaInicio,  // Actualizar fecha de inicio
                                $fechaFin    // Actualizar fecha de fin

                            );
                            if ($request_planes > 0) {
                                $arrResponse = array('status' => true, 'idplan' => $idPlan, 'msg' => 'Datos Actualizados correctamente.');
                            } else {
                                $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                            }
                        }
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }



    public function getPlan($idplan)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idplan = intval($idplan);
            if ($idplan > 0) {
                $arrData = $this->model->selectPlan($idplan);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrImg = $this->model->selectImages($idplan);
                    if (count($arrImg) > 0) {
                        for ($i = 0; $i < count($arrImg); $i++) {
                            $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                        }
                    }
                    $arrData['images'] = $arrImg;
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }





    public function setImage()
    {
        if ($_POST) {
            if (empty($_POST['id_plan'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de dato.');
            } else {
                $idPlan = intval($_POST['id_plan']);
                $foto      = $_FILES['foto'];
                $imgNombre = 'pro_' . md5(date('d-m-Y H:m:s')) . '.jpg'; //Incriptamos con md5 y se coloca la hora para que el nombre de la img no se repita importante ya que es la construccion de la ruta
                $request_image = $this->model->insertImage($idPlan, $imgNombre);
                if ($request_image) {
                    $uploadImage = uploadImage($foto, $imgNombre);
                    $arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error de carga.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delFile()
    {
        if ($_POST) {
            if (empty($_POST['idplan']) || empty($_POST['file'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                //Eliminar de la DB
                $idPlan = intval($_POST['idplan']);
                $imgNombre  = strClean($_POST['file']);
                $request_image = $this->model->deleteImage($idPlan, $imgNombre);

                if ($request_image) {
                    $deleteFile =  deleteFile($imgNombre);
                    $arrResponse = array('status' => true, 'msg' => 'Archivo eliminado');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delPlan()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdplan = intval($_POST['idPlan']);
                $requestDelete = $this->model->deletePlan($intIdplan);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el producto');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
