<?php
// Primero Trait para extraer todos los planes en MySQL y mantenimiento de la DB y se hace uso en el controller Home
require_once("Libraries/Core/Mysql.php");

trait TPlan
{
    private $con;
    private $strCategoria;
    private $intIdcategoria;
    private $intIdplan;
    private $strPlan;
    private $cant;
    private $option;
    private $strRuta;

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
                        p.ruta,
                        p.stock,     
                        p.id_lugar,
                        l.nombre AS lugar
                 FROM planes p 
                 INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                 INNER JOIN lugares l ON p.id_lugar = l.id_lugar
                 WHERE p.status != 0 ORDER BY p.id_plan DESC";

        $request = $this->con->select_all($sql); //El select_all Ya que extraemos todos los registros

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

    public function getPlanesCategoriaT(int $idcategoria, string $ruta,)
    {
        $this->intIdcategoria = $idcategoria;
        $this->strRuta = $ruta;
        $this->con = new Mysql();
        $sql_cat = "SELECT id_categoria, nombre FROM  categorias WHERE id_categoria ='{$this->intIdcategoria}'";
        $request = $this->con->select($sql_cat);
        if (!empty($request)) {
            $this->strCategoria = $request['nombre'];
            $sql = "SELECT p.id_plan,
                            p.codigo,
                            p.nombre,
                            p.descripcion,
                            p.id_categoria,
                            c.nombre AS categoria,
                            p.precio,
                            p.ruta,
                            p.stock,     
                            p.id_lugar,
                            l.nombre AS lugar
                     FROM planes p 
                     INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                     INNER JOIN lugares l ON p.id_lugar = l.id_lugar
                     WHERE p.status != 0 AND p.id_categoria = $this->intIdcategoria AND c.ruta = '{$this->strRuta}'";

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
            $request = array(
                'id_categoria' => $this->intIdcategoria,
                'categoria' => $this->strCategoria,
                'planes' => $request
            );
        }

        return $request;
    }

    public function getPlanT(int $idplan, string $ruta)
    {
        $this->con = new Mysql();
        $this->intIdplan = $idplan;
        $this->strRuta = $ruta; //Este tipo de propiedades se debe crear y poner arriba
        $sql = "SELECT p.id_plan,
                        p.codigo,
                        p.nombre,
                        p.descripcion,
                        p.id_categoria,
                        c.nombre AS categoria,
                        c.ruta AS ruta_categoria,
                        p.precio,
                        p.ruta,
                        p.stock,     
                        p.id_lugar,
                        l.nombre AS lugar,
                        l.ruta AS ruta_lugar
                 FROM planes p 
                 INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                 INNER JOIN lugares l ON p.id_lugar = l.id_lugar
                 WHERE p.status != 0 AND p.id_plan = '{$this->intIdplan}' AND p.ruta = '{$this->strRuta}'";

        $request = $this->con->select($sql); //Para que extraiga un resgistro
        if (!empty($request)) { //Si no esta vacio el array Se realiza todo lo demas
            // Asignar el valor de id_plan a una variable local
            $intIdPlan = $request['id_plan'];
            // Corregir el uso de la variable $intIdPlan en la consulta SQL
            $sqlImg = "SELECT img
                            FROM imagenp
                            WHERE id_plan = $intIdPlan";
            $arrImg = $this->con->select_all($sqlImg);
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

    public function getPlanesRandom(int $idcategoria, int $cant, string $option)
    {
        $this->intIdcategoria = $idcategoria; //Propiedades-variables
        $this->cant = $cant;
        $this->option = $option;

        //Query para extraer las categorias
        if ($option == "r") {
            $this->option = "RAND() ";
        } else if ($option == "a") {
            $this->option = "id_plan ASC ";
        } else {
            $this->option = "id_plan DESC ";
        }

        $this->con = new Mysql();
        $sql = "SELECT p.id_plan,
                                p.codigo,
                                p.nombre,
                                p.descripcion,
                                p.id_categoria,
                                c.nombre AS categoria,
                                p.precio,
                                p.ruta,
                                p.stock,     
                                p.id_lugar,
                                l.nombre AS lugar
                         FROM planes p 
                         INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                         INNER JOIN lugares l ON p.id_lugar = l.id_lugar
                         WHERE p.status != 0 AND p.id_categoria = $this->intIdcategoria 
                         ORDER BY $this->option LIMIT $this->cant";

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
