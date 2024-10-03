    <!-- Controlador -->
    <?php
    // Requerir los archivos trie donde se extrae la info 
    require_once("Models/TActividad.php");
    class Tiendati extends Controllers
    {//Usar los trait
        use TActividad;
        public function __construct()
        {
            parent::__construct();
            session_start();
        }
        public function tiendati()
        {
            //  dep($this->getActividadesT());
            //  exit;
            $data['page_tag'] = NOMBRE_EMPRESA.'- Tiendati';
            $data['page_title'] = 'Actividades en Bogota';
            $data['page_name'] = "tiendati";
            $data['actividades'] = $this->getActividadesT(); // Obtener las actividades
            $this->views->getView($this, "tiendati", $data);
        }
        
        public function detalleti($params){
            if (empty($params)) {
                header("Location:" . base_url());   
            } else {
                $arrParams = explode(",",$params);
                $idactividad = intval($arrParams[0]);
                $ruta = strClean($arrParams[1]);
                $infoActividad = $this->getActividadT( $idactividad ,$ruta);
                if(empty(  $infoActividad)){
                    header("Location:".base_url());
                }
                $data['page_tag'] = NOMBRE_EMPRESA . " - " . $infoActividad['nombre'];
                $data['page_title'] = $infoActividad['nombre'];
                $data['page_name'] = "actividad";
                $data['actividad'] =   $infoActividad;
                $data['actividades'] = $this->getActividadesRandom(8, "r");
                $this->views->getView($this, "detalleti", $data); //vista Views llamado
            }
        }
    }

    ?>