<?php
// Primero Trait para extraer todos los planes en MySQL y mantenimiento de la DB y se hace uso en el controller Home
require_once("Libraries/Core/Mysql.php");

trait TLugar
{
    private $con;
    public function getLugaresT()
    {
        $this->con = new Mysql();
        $sql = "SELECT l.id_lugar,
               l.nombre,
               l.descripcion,
               l.localidad,
               l.direccion,
               l.tipo_lugar
                FROM lugares l
                WHERE l.status != 0";
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






