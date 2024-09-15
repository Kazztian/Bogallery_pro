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
    private $strJornada;
    private $strFechaInicio;
    private $strFechaFin;
    private $strRuta;
    private $strImagen;

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
                        p.jornadap,
                        p.fecha_inicio,
                        p.fecha_fin,
                        p.id_lugar,
                        l.nombre AS lugar
                 FROM planes p 
                 INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                 INNER JOIN lugares l ON p.id_lugar = l.id_lugar
                 WHERE p.status != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    //Insertar los planes(Crear)
    public function insertPlanes(string $nombre, string $descripcion, int $codigo, int $idcategoria, $idlugar, string $precio, int $stock, string $ruta, int $status, string $jornada, string $fechaInicio, string $fechaFin)
    {
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intCodigo = $codigo;
        $this->intIdCategoria = $idcategoria;
        $this->intIdLugar = $idlugar;
        $this->strPrecio = $precio;
        $this->intStock = $stock;
        $this->strRuta = $ruta;
        $this->intStatus = $status;
        $this->strJornada = $jornada;
        $this->strFechaInicio = $fechaInicio;
        $this->strFechaFin = $fechaFin;
        $return = 0;
        $sql = "SELECT * FROM planes WHERE codigo = '{$this->intCodigo}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert  = "INSERT INTO planes(   nombre,
                                                    descripcion,
                                                    precio,
                                                    codigo,                   
                                                    stock,  
                                                    ruta,                  
                                                    status,
                                                     jornadap, 
                                                     fecha_inicio,
                                                      fecha_fin,
                                                    id_categoria,
                                                    id_lugar) 
                              VALUES(?,?,?,?,?,?,?,?,?,?,?,?)"; //Se deja la indicacion de los campos
            $arrData = array(
                $this->strNombre,
                $this->strDescripcion,
                $this->strPrecio,
                $this->intCodigo,
                $this->intStock,
                $this->strRuta,
                $this->intStatus,
                $this->strJornada,
                $this->strFechaInicio,
                $this->strFechaFin,
                $this->intIdCategoria,
                $this->intIdLugar
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    //Valida lo del codigo y las alertas
    public function checkCodeExists(string $codigo, int $excludeId = 0)
    {
        $sql = "SELECT * FROM planes WHERE codigo = '{$codigo}'";
        if ($excludeId > 0) {
            $sql .= " AND id_plan != {$excludeId}";
        }
        $request = $this->select_all($sql);
        return !empty($request);
    }
    public function updatePlanes(int $idplan, string $nombre, string $descripcion, int $codigo, int $idcategoria, int $idlugar, string $precio, int $stock, string $ruta, int $status, string $jornada, string $fechaInicio, string $fechaFin)
    {
        $this->intIdPlan = $idplan;
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intCodigo = $codigo;
        $this->intIdCategoria = $idcategoria;
        $this->intIdLugar = $idlugar;
        $this->strPrecio = $precio;
        $this->intStock = $stock;
        $this->strRuta = $ruta;
        $this->intStatus = $status;
        $this->strJornada = $jornada;
        $this->strFechaInicio = $fechaInicio;
        $this->strFechaFin = $fechaFin;
        $return = 0;

        // Verifica si el código ya existe en otro plan(No se ejecuta co)
        // $sql = "SELECT * FROM planes WHERE codigo = '{$this->intCodigo}' AND id_plan != $this->intIdPlan";
        // $request = $this->select_all($sql);

        if (empty($request)) {
            // Realiza la actualización
            $sql = "UPDATE planes 
                    SET id_categoria = ?,
                        id_lugar = ?,
                        codigo = ?,
                        nombre = ?,
                        descripcion = ?,
                        precio = ?,
                        stock = ?,
                        ruta = ?,
                        status = ?,
                         jornadap = ?,
                    fecha_inicio = ?,
                    fecha_fin = ?
                    WHERE id_plan = $this->intIdPlan";
            $arrData = array(
                $this->intIdCategoria,
                $this->intIdLugar,
                $this->intCodigo,
                $this->strNombre,
                $this->strDescripcion,
                $this->strPrecio,
                $this->intStock,
                $this->strRuta,
                $this->intStatus,
                $this->strJornada,
                $this->strFechaInicio,
                $this->strFechaFin


            );

            $request = $this->update($sql, $arrData);
            $return = $request;
        } else {
            $return = "exist";
        }

        return $return;
    }




    public function selectPlan(int $idplan)
    {
        $this->intIdPlan = $idplan;
        $sql = "SELECT p.id_plan,
                   p.codigo,
                   p.nombre,
                   p.descripcion,
                   p.id_categoria,
                   c.nombre AS categoria,
                   p.precio,
                   p.stock,
                   p.status,
                   p.jornadap,
                   p.fecha_inicio,
                   p.fecha_fin,
                   p.id_lugar,
                   l.nombre AS lugar
                FROM planes p
                INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                INNER JOIN lugares l ON p.id_lugar = l.id_lugar
                WHERE p.id_plan  = $this->intIdPlan";
        $request = $this->select($sql);
        return $request;
    }


    public function insertImage(int $idplan, string $imagen)
    {
        $this->intIdPlan = $idplan;
        $this->strImagen = $imagen;
        $query_insert  = "INSERT INTO imagenp(id_plan,img) VALUES(?,?)";
        $arrData = array(
            $this->intIdPlan,
            $this->strImagen
        );
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }


    public function selectImages(int $idplan)
    {
        $this->intIdPlan = $idplan;
        $sql = "SELECT id_plan,img
                FROM imagenp
                WHERE id_plan = $this->intIdPlan";
        $request = $this->select_all($sql);
        return $request;
    }


    public function deleteImage(int $idplan, string $imagen)
    {
        $this->intIdPlan = $idplan;
        $this->strImagen = $imagen;
        $query  = "DELETE FROM imagenp
                    WHERE id_plan = $this->intIdPlan
                    AND img = '{$this->strImagen}'";
        $request_delete = $this->delete($query);
        return $request_delete;
    }

    public function deletePlan(int $idplan)
    {
        $this->intIdPlan = $idplan;
        $sql = "UPDATE planes SET status = ? WHERE id_plan = $this->intIdPlan ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }
}
