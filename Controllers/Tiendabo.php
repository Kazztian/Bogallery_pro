<!-- Controlador -->
<?php
// Requerir los archivos trie donde se extrae la info 
require_once("Models/TCategoria.php");
require_once("Models/TPlan.php");
class Tiendabo extends Controllers
{
    use TCategoria, TPlan; //Usar los trait
    public function __construct()
    {
        parent::__construct();
    }
    // esto extre todo los planes cuando se diriga a planes
    public function tiendabo()
    {
        $data['page_tag'] = NOMBRE_EMPRESA;
        $data['page_title'] = NOMBRE_EMPRESA;
        $data['page_name'] = "tiendabo";
        $data['planes'] = $this->getPlanesT();
        $this->views->getView($this, "tiendabo", $data);
    }
    // Esta parte extrae los planes filtrador por categorias

    public function categoria($params)
    {
        if (empty($params)) {
            header("Location:" . base_url());
        } else {
            $categoria = strClean($params);
            $data['page_tag'] = NOMBRE_EMPRESA . " - " . $categoria;
            $data['page_title'] = $categoria;
            $data['page_name'] = "categoria";
            $data['planes'] = $this->getPlanesCategoriaT($categoria);
            $this->views->getView($this, "categoria", $data); //vista Views
        }
    }

    public function plan($params)
    {
        if (empty($params)) {
            header("Location:" . base_url());
        } else {
            $plan = strClean($params);
            $arrPlan = $this->getPlanT($plan);
            $data['page_tag'] = NOMBRE_EMPRESA . " - " . $plan;
            $data['page_title'] = $plan;
            $data['page_name'] = "plan";
            $data['plan'] = $arrPlan;
            $data['planes'] = $this->getPlanesRandom($arrPlan['id_categoria'], 8, "r"); //Se pone 8 para que se pongan cada que se oprime la letra, y se pone "r" para que se extraigan los planes de forma aleatoria se puede "a" y "d"
            $this->views->getView($this, "plan", $data); //vista Views llamado
        }
    }
}

?>