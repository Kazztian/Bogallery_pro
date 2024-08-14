<?php
class LugaresModel extends mysql
{
    private $intIdLugar;
    private $strNombre;
    private $strDescripcion;
    private $strLocalidad;
    private $strDireccion;
    private $strTipoLugar;
    private $intStatus;
    private $strImagen;

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
        $return = 0;

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

    public function updateLugar(
        int $idlugar,
        string $nombre,
        string $descripcion,
        string $localidad,
        string $direccion,
        string $tipolugar,
        int $status
    ) {
        $this->intIdLugar = $idlugar;
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->strLocalidad = $localidad;
        $this->strDireccion = $direccion;
        $this->strTipoLugar = $tipolugar;
        $this->intStatus = $status;
        $return = 0;

        // Usar declaraciones preparadas para evitar inyección SQL
        $sql = "SELECT * FROM lugares WHERE nombre = ? AND id_lugar != ?";
        $request = $this->select_all($sql, array($this->strNombre, $this->intIdLugar));

        if (empty($request)) {
            $sql = "UPDATE lugares
                    SET nombre=?,
                        descripcion=?,
                        localidad=?,
                        direccion=?,
                        tipo_lugar=?,
                        status=?
                    WHERE id_lugar = ?";
            $arrData = array(
                $this->strNombre,
                $this->strDescripcion,
                $this->strLocalidad,
                $this->strDireccion,
                $this->strTipoLugar,
                $this->intStatus,
                $this->intIdLugar // Añadido el id_lugar como parte de los parámetros
            );
            $request = $this->update($sql, $arrData);
            $return = $request;
        } else {
            $return = "exist";
        }

        return $return;
    }


    public function selectLugar(int $idlugar)
    {
        $this->intIdLugar = $idlugar;
        $sql = "SELECT l.id_lugar,
        l.nombre,
        l.descripcion,
        l.localidad,
        l.direccion,
        l.tipo_lugar,
        l.status
    FROM lugares l
    WHERE l.id_lugar = $this->intIdLugar";
        $request = $this->select($sql);
        return $request;
    }
    public function insertImage(int $idlugar, string $imagen)
    {
        $this->intIdLugar = $idlugar;
        $this->strImagen = $imagen;
        $query_insert = "INSERT INTO imagen(id_lugar,img) VALUES(?,?)";
        $arrData = array(
            $this->intIdLugar,
            $this->strImagen
        );
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function selectImages(int $idlugar)
    {
        $this->intIdLugar = $idlugar;
        $sql = "SELECT id_lugar,img
        FROM imagen
        WHERE id_lugar = $this->intIdLugar";
        $request = $this->select_all($sql);
        return $request;
    }

    public function deleteImage(int $idlugar, string $imagen){
        $this->intIdLugar = $idlugar;
        $this->strImagen = $imagen;
        $query  = "DELETE FROM imagen 
                    WHERE id_lugar = $this->intIdLugar 
                    AND img = '{$this->strImagen}'";
        $request_delete = $this->delete($query);
        return $request_delete;
    }

    public function deleteLugar(int $idlugar){
        $this->intIdLugar = $idlugar;
        $sql = "UPDATE lugares SET status = ? WHERE id_lugar = $this->intIdLugar ";
        $arrData = array(0);
        $request = $this->update($sql,$arrData);
        return $request;
    }
}
