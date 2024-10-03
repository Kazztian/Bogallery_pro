<?php
// Requerir los archivos trie donde se extrae la info 
class Contacto extends Controllers
{

    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function contacto()
    {

        $data['page_tag'] = NOMBRE_EMPRESA;
        $data['page_title'] = NOMBRE_EMPRESA;
        $data['page_name'] = "tienda_bogallery";

        $this->views->getView($this, "contacto", $data);
    }
}

?>