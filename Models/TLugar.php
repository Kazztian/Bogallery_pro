<?php
// Primero Trait para extraer todos los planes en MySQL y mantenimiento de la DB y se hace uso en el controller Home
require_once("Libraries/Core/Mysql.php");

trait TLugar
{
    private $con;
    private $strLugar;
    private $intIdlugar;
    private $cant;
    private $option;
    private $strRuta;
    public function getLugaresT()
    {
        $this->con = new Mysql();
        $sql = "SELECT l.id_lugar,
               l.nombre,
               l.descripcion,
               l.localidad,
               l.direccion,
               l.tipo_lugar,
               l.ruta
                FROM lugares l
                WHERE l.status != 0 ORDER BY l.id_lugar DESC";
        $request = $this->con->select_all($sql);
        if (count($request) > 0) {
            for ($l = 0; $l < count($request); $l++) {
                $intIdLugar = $request[$l]['id_lugar'];
                $sqlimg = "SELECT img
                FROM imagen
                WHERE id_lugar = $intIdLugar";
                $arrImg = $this->con->select_all($sqlimg);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $request[$l]['images'] = $arrImg;
            }
        }
        return $request;
    }
    //Se encarga de extraer un lugar
    public function getLugarT(int $idlugar, string $ruta)
    {
        $this->con = new Mysql();
        $this->intIdlugar = $idlugar;
        $this->strRuta = $ruta;
        $sql = "SELECT l.id_lugar,
               l.nombre,
               l.descripcion,
               l.localidad,
               l.direccion,
               l.tipo_lugar,
               l.ruta
                FROM lugares l
                WHERE l.status != 0 AND l.id_lugar ='{$this->intIdlugar}' AND l.ruta = '{$this->strRuta}'   ";
        $request = $this->con->select($sql);
        if (!empty($request)) {
            $intIdLugar = $request['id_lugar'];
            $sqlimg = "SELECT img
                FROM imagen
                WHERE id_lugar = $intIdLugar";
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

    public function getLugaresRandom(int $cant, string $option)
    {
        $this->cant = $cant;
        $this->option = $option;

        // Configuración de la opción de ordenamiento
        if ($option == "r") {
            $this->option = "RAND()";
        } else if ($option == "a") {
            $this->option = "id_lugar ASC";
        } else {
            $this->option = "id_lugar DESC";
        }

        $this->con = new Mysql();
        $sql = "SELECT l.id_lugar,
                    l.nombre,
                    l.descripcion,
                    l.localidad,
                    l.direccion,
                    l.tipo_lugar,
                    l.ruta
             FROM lugares l
             WHERE l.status != 0
             ORDER BY $this->option LIMIT $this->cant";

        $request = $this->con->select_all($sql);

        if (count($request) > 0) {
            for ($l = 0; $l < count($request); $l++) {
                $intIdLugar = $request[$l]['id_lugar'];
                $sqlimg = "SELECT img
                       FROM imagen
                       WHERE id_lugar = $intIdLugar";
                $arrImg = $this->con->select_all($sqlimg);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $request[$l]['images'] = $arrImg;
            }
        }
        return $request;
    }
}
