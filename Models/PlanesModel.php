<?php
class PlanesModel extends mysql
{
    private $intIdPlan;
    private $strNombre;
    private $strDescripcion;
    private $strPrecio;
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

    public function insertPlanes(string $nombre, string $descripcion, int $codigo, int $idcategoria,$idlugar, string $precio, int $stock, int $status){
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intCodigo = $codigo;
        $this->intIdCategoria = $idcategoria;
        $this->intIdLugar = $idlugar;
        $this->strPrecio = $precio;
        $this->intStock = $stock;
        $this->intStatus = $status;
        $return = 0;
        $sql = "SELECT * FROM planes WHERE codigo = '{$this->intCodigo}'";
        $request = $this->select_all($sql);
        if(empty($request))
        {
            $query_insert  = "INSERT INTO planes(   nombre,
                                                    descripcion,
                                                    precio,
                                                    codigo,                   
                                                    stock,                                status,
                                                    id_categoria,
                                                    id_lugar) 
                              VALUES(?,?,?,?,?,?,?,?)"; //Se deja la indicacion de los campos
           $arrData = array(
                            $this->strNombre,
                            $this->strDescripcion,
                            $this->strPrecio,
                            $this->intCodigo,
                            $this->intStock,  
                            $this->intStatus,
                            $this->intIdCategoria,
                            $this->intIdLugar
                         );
            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
        }else{
            $return = "exist";
        }
        return $return;
    }
}
?>