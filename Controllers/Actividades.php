<?php

class Actividades extends Controllers
{
    public function __construct()

    {
        parent::__construct();
        session_Start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(9);
    }

    public function Actividades()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Actividades";
        $data['page_title'] = "ACTIVIDADES <small>BoGallery</small>";
        $data['page_name'] = "actividades";
        $data['page_functions_js'] = "functions_actividades.js";
        $this->views->getView($this, "actividades", $data);
    }

    public function getActividades()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectActividades();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }
                $arrData[$i]['valor'] = SMONEY . ' ' . formatMoney($arrData[$i]['valor']);

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id_actividad'] . ')" title="Ver Actividad"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id_actividad'] . ')" title="Editar Actividad"><i class="bi bi-pencil-square"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id_actividad'] . ')" title="Eliminar Actividad"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setActividad()
    {
        if ($_POST) {
            if (empty($_POST['txtNombre']) || empty($_POST['txtJornada']) || empty($_POST['txtValor']) || empty($_POST['listLugar']) || empty($_POST['listStatus'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idActividad = intval($_POST['id_actividad']);
                $strNombre = strClean($_POST['txtNombre']);
                $strDescripcion = strClean($_POST['txtDescripcion']);
                $strJornada = strClean($_POST['txtJornada']);
                $strValor = strClean($_POST['txtValor']);
                $intIdLugar = intval($_POST['listLugar']);
                $intStatus = intval($_POST['listStatus']);
                $request_actividad = "";

                $ruta = strtolower(clear_cadena($strNombre));
                $ruta = str_replace(" ","-",$ruta);

                if ($idActividad == 0) {
                    $option = 1;
                    if ($_SESSION['permisosMod']['w']) {
                        $request_actividad = $this->model->insertActividad(
                            $strNombre,
                            $strDescripcion,
                            $strJornada,
                            $strValor,
                            $intIdLugar,
                            $ruta,
                            $intStatus
                        );
                    }
                } else {
                    $option = 2;
                    // Aquí podrías agregar la lógica de actualización si fuera necesario.
                    if ($_SESSION['permisosMod']['u']) {
                    $request_actividad = $this->model->updateActividad(
                        $idActividad,
                        $strNombre,
                        $strDescripcion,
                        $strJornada,
                        $strValor,
                        $intIdLugar,
                        $ruta,
                        $intStatus
                    );
                }
            }

                if ($request_actividad > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'id_actividad' => $request_actividad, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        // $arrResponse = array('status' => true, 'id_actividad' => $idActividad, 'msg' => 'Datos actualizados correctamente.');
                         $arrResponse = array('status' => true, 'id_actividad' => $idActividad, 'msg' => 'Datos Actualizados correctamente.');
                    
                    }
                } else if ($request_actividad == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un lugar con ese nombre.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getActividad($idActividad)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idActividad = intval($idActividad);
            if ($idActividad > 0) {
                $arrData = $this->model->selectActividad($idActividad);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrImg = $this->model->selectImages($idActividad);
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
            die();
        }
    }


    public function setImage()
    {
        //dep($_POST);
        //dep($_FILES);

        if ($_POST) {
            if (empty($_POST['id_actividad'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error carga.');
            } else {
                $idActividad = intval($_POST['id_actividad']);
                $foto    = $_FILES['foto'];
                $imgNombre = 'pro_' . md5(date('d-m-Y H:m:s')) . '.jpg';
                $request_image = $this->model->insertImage($idActividad, $imgNombre);
                if ($request_image) {
                    $uploadImage = uploadImage($foto, $imgNombre);
                    $arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error carga.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delFile()
    {
        if ($_POST) {
            if (empty($_POST['id_actividad']) || empty($_POST['file'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                //Eliminar de la DB
                $idActividad = intval($_POST['id_actividad']);
                $imgNombre  = strClean($_POST['file']);
                $request_image = $this->model->deleteImage($idActividad, $imgNombre);

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

    function delActividad()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdActividad = intval($_POST['id_actividad']);
                $requestDelete = $this->model->deleteActividad($intIdActividad);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el lugar');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el lugar.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
        
    }
}
