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

                $arrData[$i]['precio'] = SMONEY.' '.formatMoney($arrData[$i]['precio']);

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
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setPlanes(){
        if($_POST){
            if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['listCategoria']) || empty($_POST['listLugar']) || empty($_POST['txtPrecio']) || empty($_POST['listStatus'])){
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idPlan = intval($_POST['idPlanes']);
                $strNombre = strClean($_POST['txtNombre']);
                $strDescripcion = strClean($_POST['txtDescripcion']);
                $strCodigo = strClean($_POST['txtCodigo']);
                $intIdCategoria = intval($_POST['listCategoria']);
                $intIdLugar= intval($_POST['listLugar']);
                $strPrecio = strClean($_POST['txtPrecio']);
                $intStock= intval($_POST['txtStock']);
                $intStatus = intval($_POST['listStatus']);

                if($idPlan== 0)
					{
						$option = 1;
						if($_SESSION['permisosMod']['w']){
							$request_planes = $this->model->insertPlanes($strNombre, 
																		$strDescripcion, 
																		$strCodigo, 
																		$intIdCategoria,
                                                                        $intIdLugar,
																		$strPrecio, 
																		$intStock, 
																		$intStatus );
						}
					}else{
						$option = 2;
						if($_SESSION['permisosMod']['u']){
							$request_planes = $this->model->updateProducto($idPlan,
																		$strNombre,
																		$strDescripcion, 
																		$strCodigo, 
																		$intIdCategoria,
                                                                        $intIdLugar,
																		$strPrecio, 
																		$intStock, 
																		$intStatus);
						}
					}
                    if($request_planes > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'idplan' => $request_planes, 'msg' => 'Datos guardados correctamente.');
						}else{
							
						}
					}else if($request_planes == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el Código Ingresado.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
    
               
    
                
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setImage(){
        // dep($_POST);
        // dep($_FILES);
        $arrResponse=array('status'=>true,'imgname'=>"img_56135ss3555.jpg");
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
    }

}

?>