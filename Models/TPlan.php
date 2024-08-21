<?php
// Primero Trait para extraer todos los planes en MySQL y mantenimiento de la DB y se hace uso en el controller Home
require_once("Libraries/Core/Mysql.php");

trait TPlan
{
    private $con;

    public function getPlanesT()
    {
        $this->con = new Mysql();
        $sql = "SELECT p.id_plan,
                        p.codigo,
                        p.nombre,
                        p.descripcion,
                        p.id_categoria,
                        c.nombre AS categoria,
                        p.precio,
                        p.stock,     
                        p.id_lugar,
                        l.nombre AS lugar
                 FROM planes p 
                 INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                 INNER JOIN lugares l ON p.id_lugar = l.id_lugar
                 WHERE p.status != 0";

        $request = $this->con->select_all($sql);

        if (count($request) > 0) {
            for ($c = 0; $c < count($request); $c++) {
                // Asignar el valor de id_plan a una variable local
                $intIdPlan = $request[$c]['id_plan'];

                // Corregir el uso de la variable $intIdPlan en la consulta SQL
                $sqlImg = "SELECT img
                            FROM imagenp
                            WHERE id_plan = $intIdPlan";
                $arrImg = $this->con->select_all($sqlImg);

                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }

                $request[$c]['images'] = $arrImg;
            }
        }

        return $request;
    }
}
