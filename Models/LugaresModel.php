<?php
class LugaresModel extends mysql
{
    private $intIdLugares;
    private $strNombre;
    private $strDescripcion;
    private $strLocalidad;
    private $strDireccion;
    private $strTipoLugar;
    private $intStatus;

    function __construct()
    {
        parent::__construct();
    }

    public function selectLugares()
    {
        $sql = "SELECT l.id_lugar,
                       l.nombre,
                       l.descripcion,
                       l.localidad,
                       l.direccion,
                       l.tipo_lugar,
                       l.status
                       FROM lugares l
                       WHERE l.status != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertLugar(
        string $nombre,
        string $descripcion,
        string $localidad,
        string $direccion,
        string $tipolugar,
        int $status
    ) {
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->strLocalidad = $localidad;
        $this->strDireccion = $direccion;
        $this->strTipoLugar = $tipolugar;
        $this->intStatus = $status;

        // Usar declaraciones preparadas para evitar inyección SQL
        $sql = "SELECT * FROM lugares WHERE nombre = ?";
        $request = $this->select_all($sql, array($this->strNombre));

        if (empty($request)) {
            $query_insert = "INSERT INTO lugares(nombre, descripcion, localidad, direccion, tipo_lugar, status)
                             VALUES(?, ?, ?, ?, ?, ?)";
            $arrData = array(
                $this->strNombre,
                $this->strDescripcion,
                $this->strLocalidad,
                $this->strDireccion,
                $this->strTipoLugar,
                $this->intStatus
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }

        return $return;
    }
}
