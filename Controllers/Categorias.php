<?php
class Categorias extends Controllers
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
        getPermisos(6);
    }

    public function Categorias()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Categorias";
        $data['page_title'] = "CATEGORIAS <small>BoGallery</small>";
        $data['page_name'] = "categorias";
        $data['page_functions_js'] = "functions_categorias.js";
        $this->views->getView($this, "categorias", $data);
    }

    public function setCategoria()
    {
        if ($_POST) {
            if (empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['listStatus'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdcategoria = intval($_POST['idCategoria']);
                $strCategoria = strClean($_POST['txtNombre']);
                $strDescipcion = strClean($_POST['txtDescripcion']);
                $intStatus = intval($_POST['listStatus']);

                $ruta = strtolower(clear_cadena($strCategoria)); //Obtenemos el normbre en nimisculas y sin tiles con la funcion
                $ruta = str_replace(" ","-",$ruta);


                $foto = $_FILES['foto'];
                $nombre_foto = $foto['name'];
                $type = $foto['type'];
                $url_temp = $foto['tmp_name'];
                $imgPortada = 'portada_categoria.jpg';
                $request_cateria = "";

                if ($nombre_foto != '') {
                    $imgPortada = 'img_' . md5(date('d-m-Y H:m:s')) . '.jpg';
                }

                if ($intIdcategoria == 0) {
                    // Crear
                    if ($_SESSION['permisosMod']['w']) {
                        $request_cateria = $this->model->insertCategoria($strCategoria, $strDescipcion, $imgPortada,$ruta,$intStatus);
                        $option = 1;
                    }
                } else {
                    // Actualizar
                    if ($_SESSION['permisosMod']['u']) {
                        if ($nombre_foto == '') {
                            if ($_POST['foto_actual'] != 'portada_categoria.jpg' && $_POST['foto_remove'] == 0) {
                                $imgPortada = $_POST['foto_actual'];
                            }
                        }
                        $request_cateria = $this->model->updateCategoria($intIdcategoria, $strCategoria, $strDescipcion, $imgPortada,$ruta,$intStatus);
                        $option = 2;
                    }
                }

                // Agregar depuración
                error_log("Valor de request_cateria: " . $request_cateria);

                if ($request_cateria === 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! La categoría ya existe.');
                } elseif ($request_cateria > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        if ($nombre_foto != '') {
                            uploadImage($foto, $imgPortada);
                        }
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                        if ($nombre_foto != '') {
                            uploadImage($foto, $imgPortada);
                        }

                        if (($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.jpg')
                            || ($nombre_foto != '' && $_POST['foto_actual'] != 'portada_categoria.jpg')
                        ) {
                            deleteFile($_POST['foto_actual']);
                        }
                    }
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCategorias()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectCategorias();
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
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id_categoria'] . ')" title="Ver categoría"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id_categoria'] . ')" title="Editar categoría"><i class="bi bi-pencil-square"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['id_categoria'] . ')" title="Eliminar categoría"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCategoria($idcategoria)
    {
        if ($_SESSION['permisosMod']['r']) {
            $intIdcategoria = intval($idcategoria);
            if ($intIdcategoria > 0) {
                $arrData = $this->model->selectCategoria($intIdcategoria);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrData['url_portada'] = media() . '/images/uploads/' . $arrData['portada'];
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delCategoria()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $intIdcategoria = intval($_POST['id_categoria']);
                $requestDelete = $this->model->deleteCategoria($intIdcategoria);
                if ($requestDelete == 'ok') {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la categoría');
                } else if ($requestDelete == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar una categoría con planes asociados.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la categoría.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    //Funcion para extraer las categorias en la lista de planes
    public function getSelectCategorias()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectCategorias();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['id_categoria'] . '">' . $arrData[$i]['nombre'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }
}
