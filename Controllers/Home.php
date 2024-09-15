<!-- Controlador -->
<?php
// Requerir los archivos trie donde se extrae la info 
require_once("Models/TCategoria.php");
require_once("Models/TPlan.php");
class Home extends Controllers
{
    use TCategoria, TPlan; //Usar los trait
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function home()
    {
        // dep($this->getLugaresT());
        // exit;
        $data['page_tag'] = NOMBRE_EMPRESA;
        $data['page_title'] = NOMBRE_EMPRESA;
        $data['page_name'] = "tienda_bogallery";
        $data['slider'] = $this->getCategoriasT(CAT_SLIDER);
        $data['banner'] = $this->getCategoriasT(CAT_BANNER);
        $data['planes'] = $this->getPlanesT();
        $this->views->getView($this, "home", $data);
    }
}

?>