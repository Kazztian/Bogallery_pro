<!-- Controlador -->
<?php
// Requerir los archivos trie donde se extrae la info 
require_once("Models/TCategoria.php");
require_once("Models/TPlan.php");
class Carrito extends Controllers
{
    use TCategoria, TPlan; //Usar los trait
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function carrito()
    {
        $data['page_tag'] = NOMBRE_EMPRESA.' - Carrito';
        $data['page_title'] = 'Carrito de compras';
        $data['page_name'] = "carrito";
        $this->views->getView($this, "carrito", $data);
    }
}

?>