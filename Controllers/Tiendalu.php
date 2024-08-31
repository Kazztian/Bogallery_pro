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
            $lugar = strClean($params);
            $data['page_tag'] = NOMBRE_EMPRESA . " - " . $lugar;
            $data['page_title'] =  $lugar;
            $data['page_name'] = "lugar";
            //$data['lugar'] = "";
            //$data['lugares'] = $this->getLugaresT(); 
            $this->views->getView($this, "detallelu", $data); //vista Views llamado
        }
    }
}

?>