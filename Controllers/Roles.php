<?php

class Roles extends Controllers
{

    public function __construct()
    {
        
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }

        getPermisos(2);
    }
    public function Roles()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['page_id'] = 3;
        $data['page_tag'] = "Roles Usuario";
        $data['page_name'] = "rol_usuario";
        $data['page_title'] = " Roles usuario <small> BoGallery </small>";
        $data['page_functions_js'] = "functions_roles.js";
        $this->views->getView($this, "roles", $data);
    }
    //Metodo para extraer los roles
    public function getRoles()
    {
        if ($_SESSION['permisosMod']['r']) {
        $btnView = "";
        $btnEdit = "";
        $btnDelete = "";
        $arrData = $this->model->selectRoles();

        // for para que se muestre el mensae correcto dependiendo del status, se recorre todo el array y llega a la posicion del status 
        for ($i = 0; $i < count($arrData); $i++) {


            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="me-1 badge bg-success" style="display: inline-block; font-size: 0.9rem;">Activo</span>';
            } else {
                $arrData[$i]['status'] = '<span class="me-1 badge bg-danger"style="display: inline-block; font-size: 0.9rem;">Inactivo</span>';
            }
      

            if ($_SESSION['permisosMod']['u']) {
                $btnView = '<button class="btn btn-outline-secondary btn-sm btnPermisosRol" onClick="fntPermisos(' . $arrData[$i]['id_rol'] . ')"title="Permisos"><i class="bi bi-key-fill"></i></button>';
           
                $btnEdit = ' <button class="btn btn-warning btn-sm btnEditRol" onClick="fntEditRol(' . $arrData[$i]['id_rol'] . ')" title="Editar"><i class="bi bi-pencil-square"></i></button>';
            }

            if ($_SESSION['permisosMod']['d']) {
                $btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol(' . $arrData[$i]['id_rol'] . ')" title="Eliminar"><i class="bi bi-trash"></i></button>
                </div>';
            }


            $arrData[$i]['options'] = '<div class="text-center"> ' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . ' </div>';
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE); //Formato json para que pueda ser interpretado por cualquier lenguaje(Se convierta en un objeto)
    }
        die();  //Finaliza el proceso
    }
    /*metodo que se invoca un fuction_usuarios y 
    extrae los roles de la consulta que esta en RolesModel 
    en la funcion selectRoles*/
    public function getSelectRoles()
    {
        $htmlOptions = "";
        $arrData = $this->model->selectRoles();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['id_rol'] . '">' . $arrData[$i]['nombrerol'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }
    public function getRol(int $idrol)
    {
        if ($_SESSION['permisosMod']['r']) {
        $intIdrol = intval(strClean($idrol));
        if ($intIdrol > 0) // si es un id mayor a 0 asi que si es valido, y se realiza lo de adenro
        {
            $arrData = $this->model->selectRol($intIdrol);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrado.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } // de sevuelva, y se convierte en formato Json
    }
        die();
    }





    //Crear un Rol
    public function setRol()
    {
        if ($_SESSION['permisosMod']['w']) {
        $intIdrol = intval($_POST['idrol']);
        $strRol = strClean($_POST['txtNombre']); //la funcionClean Nos sirve para prevenir inyecciones o ataques
        $strDescripcion = strClean($_POST['txtDescripcion']);
        $intStatus = intval($_POST['listStatus']);

        if ($intIdrol == 0) {
            //crear
            $request_rol = $this->model->insertRol($strRol, $strDescripcion, $intStatus);
            $option = 1;
        } else {
            //Actualizar  
            $request_rol = $this->model->updateRol($intIdrol, $strRol, $strDescripcion, $intStatus);
            $option = 2;
        }

        //Se valida el crear un rol y actualizar

        if ($request_rol > 0) {
            if ($option == 1) {   //Rol nuevo
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
            } else { //Actualizar un rol
                $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
            }
        } else if ($request_rol == 0) {

            $arrResponse = array('status' => false, 'msg' => 'Atencion el Rol ya existe.');
        } else {
            $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
        }
        
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }
        die();
    }

    //funcion de eliminar rol
    public function delRol()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
            $intIdRol = intval($_POST['idrol']); // Cambiar a $intIdRol
            $requestDelete = $this->model->deleteRol($intIdRol); // Cambiar a $intIdRol
            if ($requestDelete == 'ok') {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
            } else if ($requestDelete == 'exist') {
                $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Rol asociado a un usuario');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar Rol');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }
        die();
    }
}
