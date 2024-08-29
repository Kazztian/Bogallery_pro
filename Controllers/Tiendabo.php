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
        session_start();
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
            $arrParams = explode(",", $params);
            $idCategoria = intval($arrParams[0]);
            $ruta = strClean($arrParams[1]);
            $infoCategoria = $this->getPlanesCategoriaT($idCategoria, $ruta);
            $categoria = strClean($params);
            $data['page_tag'] = NOMBRE_EMPRESA . " - " .  $infoCategoria['categoria'];
            $data['page_title'] =  $infoCategoria['categoria'];
            $data['page_name'] = "categoria";
            $data['planes'] = $infoCategoria['planes'];
            $this->views->getView($this, "categoria", $data); //vista Views
        }
    }

    public function plan($params)
    {
        if (empty($params)) {
            header("Location:" . base_url());
        } else {

            $arrParams = explode(",", $params); //Explode funcion propia de php que combierte en un arry ese elemento
            $idplan = intval($arrParams[0]);
            $ruta = strClean($arrParams[1]);
            $infoPlan = $this->getPlanT($idplan, $ruta);
            if (empty($infoPlan)) {
                header("Location:" . base_url());
            }
            $data['page_tag'] = NOMBRE_EMPRESA . " - " . $infoPlan['nombre'];
            $data['page_title'] = $infoPlan['nombre'];
            $data['page_name'] = "plan";
            $data['plan'] = $infoPlan;
            $data['planes'] = $this->getPlanesRandom($infoPlan['id_categoria'], 8, "r"); //Se pone 8 para que se pongan cada que se oprime la letra, y se pone "r" para que se extraigan los planes de forma aleatoria se puede "a" y "d"
            $this->views->getView($this, "plan", $data); //vista Views llamado
        }
    }
}

?>