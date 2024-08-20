<?php

class Lugares extends Controllers
{
    public function __construct()

    {
        parent::__construct();
        session_Start();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        getPermisos(8);
    }

    public function Lugares()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Lugares";
        $data['page_title'] = "LUGARES <small>BoGallery</small>";
        $data['page_name'] = "lugares";
        $data['page_functions_js'] = "functions_lugares.js";
        $this->views->getView($this, "lugares", $data);
    }

    public function getLugares()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectLugares();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id_lugar'] . ')" title="Ver lugar"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id_lugar'] . ')" title="Editar lugar"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id_lugar'] . ')" title="Eliminar lugar"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function setLugar()
    {
        if ($_POST) {
            if (empty($_POST['txtNombre']) || empty($_POST['txtLocalidad']) || empty($_POST['txtDireccion']) || empty($_POST['txtTipoLugar']) || empty($_POST['listStatus'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idLugar = intval($_POST['id_lugar']);
                $strNombre = strClean($_POST['txtNombre']);
                $strLocalidad = strClean($_POST['txtLocalidad']);
                $strDireccion = strClean($_POST['txtDireccion']);
                $strDescripcion = strClean($_POST['txtDescripcion']);
                $strTipoLugar = strClean($_POST['txtTipoLugar']);
                $intStatus = intval($_POST['listStatus']);
                $request_lugar = "";

                if ($idLugar == 0) {
                    $option = 1;
                    if ($_SESSION['permisosMod']['w']) {
                        $request_lugar = $this->model->insertLugar(
                            $strNombre,
                            $strDescripcion,
                            $strLocalidad,
                            $strDireccion,
                            $strTipoLugar,
                            $intStatus
                        );
                    }
                } else {
                    $option = 2;
                    if ($_SESSION['permisosMod']['r']) {
                        $request_lugar = $this->model->updateLugar(
                            $idLugar,
                            $strNombre,
                            $strDescripcion,
                            $strLocalidad,
                            $strDireccion,
                            $strTipoLugar,
                            $intStatus
                        );
                    }
                }

                if ($request_lugar > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'id_lugar' => $request_lugar, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'id_lugar' => $idLugar, 'msg' => 'Datos Actualizados correctamente.');
                    }
                } else if ($request_lugar == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un lugar con ese nombre.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getLugar($idLugar)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idLugar = intval($idLugar);
            if ($idLugar > 0) {
                $arrData = $this->model->selectLugar($idLugar);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrImg = $this->model->selectImages($idLugar);
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
            if (empty($_POST['id_lugar'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de dato.');
            } else {
                $idLugar = intval($_POST['id_lugar']);
                $foto = $_FILES['foto'];
                $imgNombre = 'pro' . md5(date('d-m-Y H:m:s')) . '.jpg';
                $request_image = $this->model->insertImage($idLugar, $imgNombre);
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
            if (empty($_POST['id_lugar']) || empty($_POST['file'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                //Eliminar de la DB
                $idLugar = intval($_POST['id_lugar']);
                $imgNombre  = strClean($_POST['file']);
                $request_image = $this->model->deleteImage($idLugar, $imgNombre);

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

    function delLugar()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdLugar = intval($_POST['id_lugar']);
                $requestDelete = $this->model->deleteLugar($intIdLugar);
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

    public function getSelectLugares()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectLugares($htmlOptions);
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['id_lugar'] . '">' . $arrData[$i]['nombre'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }
}
