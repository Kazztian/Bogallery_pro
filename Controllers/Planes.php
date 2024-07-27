<?php
class Planes extends Controllers
{
    public function __construct()

    {
        parent::__construct();
        session_Start();
        session_regenerate_id(true);
        if (empty($_SESSION['login']))
         {
            header('Location: ' . base_url() . '/login');
        }
        getPermisos(7);
    }

    public function Planes()
    {
        if(empty($_SESSION['permisosMod']['r'])){
            header("Location:".base_url().'/dashboard');
        }
        $data['page_tag'] = "Planes";
        $data['page_title'] = "PLANES <small>BoGallery</small>";
        $data['page_name'] = "planes";
        $data['page_functions_js'] = "functions_planes.js";
        $this->views->getView($this,"planes",$data);
    }

    public function getPlanes()
    {
        if($_SESSION['permisosMod']['r']){
            $arrData = $this->model->selectPlanes();
            for ($i=0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if($arrData[$i]['status'] == 1)
                {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                }else{
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                if($_SESSION['permisosMod']['r']){
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['id_plan'].')" title="Ver Plan"><i class="far fa-eye"></i></button>';
                }
                if($_SESSION['permisosMod']['u']){
                    $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['id_plan'].')" title="Editar Plan"><i class="fas fa-pencil-alt"></i></button>';
                }
                if($_SESSION['permisosMod']['d']){	
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['id_plan'].')" title="Eliminar Plan"><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}

?>