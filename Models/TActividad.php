<?php
require_once("Libraries/Core/Mysql.php");

trait TActividad
{
    private $con;
    private $strActividad;
    private $intIdActividad;
    private $cant;
    private $option;
    private $strRuta;

    public function getActividadesT()
    {
        $this->con = new Mysql();
        $sql = "SELECT a.id_actividad,
                       a.nombre,
                       a.descripcion,
                       a.jornada,
                       a.valor,
                       a.ruta,
                       a.id_lugar,
                       l.nombre AS lugar
                FROM Actividades a
                INNER JOIN lugares l ON a.id_lugar = l.id_lugar
                WHERE a.status != 0
                ORDER BY a.id_actividad DESC";
        $request = $this->con->select_all($sql);

        if (count($request) > 0) {
            for ($a = 0; $a < count($request); $a++) {
                $intIdActividad = $request[$a]['id_actividad'];
                $sqlimg = "SELECT img
                           FROM imagena
                           WHERE id_actividad = $intIdActividad";
                $arrImg = $this->con->select_all($sqlimg);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $request[$a]['images'] = $arrImg;
            }
        }

        return $request;
    }

    public function getActividadT(int $idactividad, string $ruta)
    {
        $this->con = new Mysql();
        $this->intIdActividad = $idactividad;
        $sql = "SELECT a.id_actividad,
                       a.nombre,
                       a.descripcion,
                       a.jornada,
                       a.valor,
                       a.ruta,
                       a.id_lugar,
                       l.nombre AS lugar,
                       l.ruta AS ruta_lugar
                FROM Actividades a
                INNER JOIN lugares l ON a.id_lugar = l.id_lugar
                WHERE a.status != 0 AND a.id_actividad = '{$this->intIdActividad}' AND a.ruta = '{$ruta}'";
        $request = $this->con->select($sql);

        if (!empty($request)) {
            $intIdActividad = $request['id_actividad'];
            $sqlimg = "SELECT img
                       FROM imagena 
                       WHERE id_actividad = $intIdActividad";
            $arrImg = $this->con->select_all($sqlimg);
            if (count($arrImg) > 0) {
                for ($i = 0; $i < count($arrImg); $i++) {
                    $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                }
            } else {
                $arrImg[0]['url_image'] = media() . '/images/uploads/portada_categorias.jpg';
            }
            $request['images'] = $arrImg;
        }

        return $request;
    }

    public function getActividadesRandom(int $cant, string $option)
    {
        $this->cant = $cant;
        $this->option = $option;

        // Configuración de la opción de ordenamiento
        if ($option == "r") {
            $this->option = "RAND()";
        } else if ($option == "a") {
            $this->option = "id_actividad ASC";
        } else {
            $this->option = "id_actividad DESC";
        }

        $this->con = new Mysql();
        $sql = "SELECT a.id_actividad,
                       a.nombre,
                       a.descripcion,
                       a.jornada,
                       a.valor,
                       a.ruta,
                       a.id_lugar,
                       l.nombre AS lugar_nombre
                FROM Actividades a
                INNER JOIN lugares l ON a.id_lugar = l.id_lugar
                WHERE a.status != 0
                ORDER BY $this->option
                LIMIT $this->cant";
        $request = $this->con->select_all($sql);

        if (count($request) > 0) {
            for ($a = 0; $a < count($request); $a++) {
                $intIdActividad = $request[$a]['id_actividad'];
                $sqlimg = "SELECT img
                           FROM imagena
                           WHERE id_actividad = $intIdActividad";
                $arrImg = $this->con->select_all($sqlimg);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $request[$a]['images'] = $arrImg;
            }
        }

        return $request;
    }
}
