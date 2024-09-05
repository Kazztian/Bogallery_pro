<?php
class ActividadesModel extends mysql
{
    private $intIdActividad;
    private $strNombre;
    private $strDescripcion;
    private $strJornada;
    private $strValor;
    private $intIdLugar;
    private $strRuta;
    private $intStatus;
    private $strImagen;

    function __construct()

    {
        parent::__construct();
    }

    public function selectActividades()
    {
        $sql = "SELECT  a.id_actividad,
                        a.nombre,
                        a.descripcion,
                        a.jornada,
                        a.valor,
                        l.nombre as lugares,
                        a.status
                FROM actividades a
                INNER JOIN lugares l 
                ON l.id_lugar = a.id_lugar
                WHERE a.status != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertActividad(
        string $nombre,
        string $descripcion,
        string $jornada,
        string $valor,
        int $lugar,
        string $ruta,
        int $status
    ) {
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->strJornada = $jornada;
        $this->strValor = $valor;
        $this->intIdLugar = $lugar;
        $this->strRuta = $ruta;
        $this->intStatus = $status;
        $return = 0;

        // Usar declaraciones preparadas para evitar inyección SQL
        $sql = "SELECT * FROM actividades WHERE nombre = ?";
        $request = $this->select_all($sql, array($this->strNombre));

        if (empty($request)) {
            $query_insert = "INSERT INTO actividades(nombre, descripcion, jornada, valor, id_lugar , ruta, status)
                             VALUES(?, ?, ?, ?, ?, ?,?)";
            $arrData = array(
                $this->strNombre,
                $this->strDescripcion,
                $this->strJornada,
                $this->strValor,
                $this->intIdLugar,
                $this->strRuta,
                $this->intStatus
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }

        return $return;
    }

    public function updateActividad(
        int $idactividad,
        string $nombre,
        string $descripcion,
        string $jornada,
        string $valor,
        int $lugar,
        string $ruta,
        int $status
    ) {
        $this->intIdActividad = $idactividad;
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->strJornada = $jornada;
        $this->strValor = $valor;
        $this->intIdLugar = $lugar;
        $this->strRuta = $ruta;
        $this->intStatus = $status;

        // Usar declaraciones preparadas para evitar inyección SQL
        $sql = "SELECT * FROM actividades WHERE nombre = ? AND id_actividad != ?";
        $request = $this->select_all($sql, array($this->strNombre, $this->intIdActividad));

        if (empty($request)) {
            $sql = "UPDATE actividades
                    SET id_lugar = ?,
                        nombre = ?,
                        descripcion = ?,
                        jornada = ?,
                        valor = ?,
                        ruta = ?,
                        status = ?
                    WHERE id_actividad = ?";
            $arrData = array(
                $this->intIdLugar,
                $this->strNombre,
                $this->strDescripcion,
                $this->strJornada,
                $this->strValor,
                $this->strRuta,
                $this->intStatus,
                $this->intIdActividad
            );
            $request = $this->update($sql, $arrData);
            return $request;
        } else {
            return "exist";
        }
        return $return;
    }




    public function selectActividad(int $idactividad)
    {
        $this->intIdActividad = $idactividad;
        $sql = "SELECT a.id_actividad,
                a.nombre,
                a.descripcion,
                a.jornada,
                a.valor,
            a.id_lugar,
            l.nombre as lugares,
            a.status
            FROM actividades a
            INNER JOIN  lugares l
            ON a.id_lugar = l.id_lugar
            WHERE id_actividad = $this->intIdActividad";
        $request = $this->select($sql);
        return $request;
    }

    //Funcion para insertar las imagenes en la base de datos 
    //Esta conectado con el controller en el public funccion set imagen
    public function insertImage(int $idactividad, string $imagen)
    {
        $this->intIdActividad = $idactividad;
        $this->strImagen = $imagen;
        $query_insert = "INSERT INTO imagena(id_actividad,img) VALUES(?,?)";
        $arrData = array(
            $this->intIdActividad,
            $this->strImagen
        );
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function selectImages(int $idactividad)
    {
        $this->intIdActividad = $idactividad;
        $sql = "SELECT id_actividad,img
        FROM imagena
        WHERE id_actividad = $this->intIdActividad";
        $request = $this->select_all($sql);
        return $request;
    }

    public function deleteImage(int $idactividad, string $imagen)
    {
        $this->intIdActividad = $idactividad;
        $this->strImagen = $imagen;
        $query  = "DELETE FROM imagena 
                    WHERE id_actividad = $this->intIdActividad 
                    AND img = '{$this->strImagen}'";
        $request_delete = $this->delete($query);
        return $request_delete;
    }

    public function deleteActividad(int $idactividad)
    {
        $this->intIdActividad = $idactividad;
        $sql = "UPDATE actividades SET status = ? WHERE id_actividad = $this->intIdActividad ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }
}
