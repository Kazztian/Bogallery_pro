<?php
class PlanesModel extends mysql
{
    private $intIdPlan;
    private $strNombre;
    private $strDescripcion;
    private $intPrecio;
    private $intCodigo;
    private $intStock;
    private $intIdCategoria;
    private $intIdLugar;
    private $intStatus;

    function __construct()
    {
        parent::__construct();
    }

    public function selectPlanes()
    {
        $sql = "SELECT p.id_plan,
                        p.codigo,
                        p.nombre,
                        p.descripcion,
                        p.id_categoria,
                        c.nombre AS categoria,
                        p.precio,
                        p.stock,
                        p.status,
                        p.id_lugar,
                        l.nombre AS lugar
                 FROM planes p 
                 INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                 INNER JOIN lugares l ON p.id_lugar = l.id_lugar
                 WHERE p.status != 0";
        $request = $this->select_all($sql);
        return $request;
    }
}
?>