<?php
// Primero Trait para extraer todos los planes en MySQL y mantenimiento de la DB y se hace uso en el controller Home
require_once("Libraries/Core/Mysql.php");

trait TPlan
{
    private $con;
    private $strCategoria;
    private $intIdcategoria;
    private $strPlan;
    private $cant;
    private $option;

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

    public function getPlanesCategoriaT(string $categoria)
    {
        $this->strCategoria = $categoria;
        $this->con = new Mysql();
        $sql_cat = "SELECT id_categoria FROM  categorias WHERE nombre ='{$this->strCategoria}'";
        $request = $this->con->select($sql_cat);
        if (!empty($request)) {
            $this->intIdcategoria = $request['id_categoria'];
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
                     WHERE p.status != 0 AND p.id_categoria = $this->intIdcategoria";

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
        }

        return $request;
    }

    public function getPlanT(string $plan)
    {
        $this->con = new Mysql();
        $this->strPlan = $plan; //Este tipo de propiedades se debe crear y poner arriba
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
                 WHERE p.status != 0 AND p.nombre = '{$this->strPlan}'";

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
