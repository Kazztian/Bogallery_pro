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
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE); //Formato json para que pueda ser interpretado por cualquier lenguaje(Se convierta en un objeto)
        die();  //Finaliza el proceso
    }
    
}
?>