<?php

class Roles extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }
    public function Roles()
    {
        $data['page_id'] = 3;
        $data['page_tag'] = "Roles Usuario";
        $data['page_name'] = "rol_usuario";
        $data['page_title'] = " Roles usuario <small> BoGallery </small>";
        $this->views->getView($this,"roles", $data);
    }

    public function getRoles()
    {
         $arrData = $this->model->selectRoles();

    // for para que se muestre el mensae correcto dependiendo del status, se recorre todo el array y llega a la posicion del status 
         for($i=0; $i < count($arrData); $i++ ){

            if( $arrData[$i]['status']==1){
                $arrData[$i]['status']= '<span class="me-1 badge bg-success" style="display: inline-block; font-size: 0.9rem;">Activo</span>';
            }else{
                $arrData[$i]['status']= '<span class="me-1 badge bg-danger"style="display: inline-block; font-size: 0.9rem;">Inactivo</span>';


            }
            $arrData[$i]['options'] = '<div class="text-center">
            <button class="btn btn-outline-secondary btn-sm btnPermisosRol" rl="'.$arrData[$i]['id_rol'].'"  title="Permisos"><i class="bi bi-key-fill"></i></button>

            <button class="btn btn-warning btn-sm btnEditRol" rl="'.$arrData[$i]['id_rol'].'" title="Editar"><i class="bi bi-pencil-square"></i></button>

            <button class="btn btn-danger btn-sm btnDelRol" rl="'.$arrData[$i]['id_rol'].'" title="Eliminar"><i class="bi bi-trash"></i></button>
            </div>';
         } 

        echo json_encode($arrData,JSON_UNESCAPED_UNICODE); //Formato json para que pueda ser interpretado por cualquier lenguaje(Se convierta en un objeto)
        die();  //Finaliza el proceso
    }
    
}
?>