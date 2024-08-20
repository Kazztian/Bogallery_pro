<?php

class Actividades extends Controllers
{
    public function __construct()

    {
        parent::__construct();
        session_Start();
        session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        getPermisos(9);
    }

    public function Actividades()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Actividades";
        $data['page_title'] = "Actividades <small>BoGallery</small>";
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
                $arrData[$i]['valor'] = SMONEY.' '.formatMoney($arrData[$i]['valor']); 

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['id_actividad'] . ')" title="Ver Actividad"><i class="far fa-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['id_actividad'] . ')" title="Editar Actividad"><i class="fas fa-pencil-alt"></i></button>';
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

    public function setActividades()
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
    
                if ($idActividad == 0) {
                    $option = 1;
                    if ($_SESSION['permisosMod']['w']) {
                        $request_actividad = $this->model->insertActividad(
                            $strNombre,
                            $strDescripcion,
                            $strJornada,
                            $strValor,
                            $intIdLugar,
                            $intStatus
                        );
                    }
                } else {
                    $option = 2;
                    // Aquí podrías agregar la lógica de actualización si fuera necesario.
                }
    
                if ($request_actividad > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'id_actividad' => $request_actividad, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'id_actividad' => $idActividad, 'msg' => 'Datos actualizados correctamente.');
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
    
}
