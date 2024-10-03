<!-- Controlador -->
<?php
// Requerir los archivos trie donde se extrae la info 
require_once("Models/TLugar.php");
class Tiendalu extends Controllers
{//Usar los trait
    use TLugar;
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function tiendalu()
    {
        //  dep($this->getLugaresT());
        //  exit;
        $data['page_tag'] = NOMBRE_EMPRESA.'- Tiendalu';
        $data['page_title'] = 'Lugares Magicos';
        $data['page_name'] = "tiendalu";
        $data['lugares'] = $this->getLugaresT(); // Obtener los lugares
        $this->views->getView($this, "tiendalu", $data);
    }
    
    public function detallelu($params){
        if (empty($params)) {
            header("Location:" . base_url());   
        } else {
            $arrParams = explode(",",$params);
            $idlugar = intval($arrParams[0]);
            $ruta = strClean($arrParams[1]);
            $infoLugar = $this->getLugarT($idlugar,$ruta);
            if(empty($infoLugar)){
                header("Location:".base_url());
            }
            $data['page_tag'] = NOMBRE_EMPRESA . " - " . $infoLugar['nombre'];
            $data['page_title'] = $infoLugar['nombre'];
            $data['page_name'] = "lugar";
            $data['lugar'] = $infoLugar;
            $data['lugares'] = $this->getLugaresRandom(8, "r");
            $this->views->getView($this, "detallelu", $data); //vista Views llamado
        }
    }
}

?>