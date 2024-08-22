<?php
class ActividadesModel extends mysql
{
    private $intIdActividad;
    private $strNombre;
    private $strDescripcion;
    private $strJornada;
    private $strValor;
    private $intIdLugar;
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
        int $status
    ) {
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->strJornada = $jornada;
        $this->strValor = $valor;
        $this->intIdLugar = $lugar;
        $this->intStatus = $status;
        $return = 0;

        // Usar declaraciones preparadas para evitar inyección SQL
        $sql = "SELECT * FROM actividades WHERE nombre = ?";
        $request = $this->select_all($sql, array($this->strNombre));

        if (empty($request)) {
            $query_insert = "INSERT INTO actividades(nombre, descripcion, jornada, valor, id_lugar , status)
                             VALUES(?, ?, ?, ?, ?, ?)";
            $arrData = array(
                $this->strNombre,
                $this->strDescripcion,
                $this->strJornada,
                $this->strValor,
                $this->intIdLugar,
                $this->intStatus
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }

        return $return;
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
}
