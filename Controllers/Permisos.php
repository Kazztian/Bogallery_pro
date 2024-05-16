<?php

class Permisos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }
   public function getPermisosRol(int $idrol)
   {
      $rolid = intval($idrol);
      if($rolid > 0)
      {
        $arrModulos = $this->model->selectModulos();
        $arrPermisosRol = $this->model->selectPermisosRol($rolid);
        $arrPermisos = array('r'=> 0, 'w'=>0, 'u'=>0,'d'=>0);
        $arrPermisoRol = array('idrol'=>$rolid);

        if(empty($arrPermisosRol))
        {
          for ($i=0; $i< count($arrModulos) ; $i++){
            $arrModulos[$i]['permisos']=$arrPermisos;
          }
        }else{
          for ($i=0; $i< count($arrModulos) ; $i++){
            $arrPermisos = array('r'=>$arrPermisosRol[$i]['r'],
                                  'w'=>$arrPermisosRol[$i]['w'],
                                  'u'=>$arrPermisosRol[$i]['u'],
                                  'd'=>$arrPermisosRol[$i]['d']
                                     
          );
           if($arrModulos[$i]['id_modulo']==$arrPermisosRol[$i]['id_modulo'])
           {
            $arrModulos[$i]['permisos'] = $arrPermisos;
           }
         
          }

        }
        $arrPermisoRol['modulos'] = $arrModulos;
        $html = getModal("modalPermisos",$arrPermisoRol); 
        echo $html;



      }
      die();
   }

   public function setPermisos()
   {
    $requestPermisos = 0; // Inicializar la variable
    
    if($_POST)
    {
      $intIdrol = intval($_POST['idrol']);
      $modulos = $_POST['modulos'];
      
      $this->model->deletePermisos($intIdrol);
      foreach ($modulos as $modulos)
      {
        $idModulo = $modulos['id_modulo'];
        $r = empty($modulos['r']) ? 0 : 1;
        $w = empty($modulos['w']) ? 0 : 1;
        $u = empty($modulos['u']) ? 0 : 1;
        $d = empty($modulos['d']) ? 0 : 1;
        $arrPermiso = $this->model->insertPermisos($intIdrol,$idModulo,$r,$w,$u ,$d);

      }

      if($requestPermisos > 0)
      {
        $arrRespose = array(' status' => true, 'msg' => 'Permisos asignados correctamente');

      }else{
        $arrRespose = array(' status' => true, 'msg' => 'No es posible asignar los permisos');

      }
      echo json_encode($arrRespose,JSON_UNESCAPED_UNICODE);
    }
    die();  
    

   }
    

}
?>