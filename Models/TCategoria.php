<?php

//Primero Trait para extraer todas las categorias y se hace uso en el cotroller home
require_once("Libraries/Core/Mysql.php");
trait TCategoria
{
    private $con;

    public function getCategoriasT(string $categorias)
    {
        $this->con = new Mysql();
        $sql = "SELECT id_categoria, nombre, descripcion, portada, ruta
        FROM categorias WHERE status !=0 AND id_categoria IN ($categorias)"; //Las imagenes que se visualizan en el slider, en las fotos principales
        $request = $this->con->select_all($sql);
        if (count($request) > 0) {
            for ($c = 0; $c < count($request); $c++) {
                $request[$c]['portada'] = BASE_URL . '/Assets/images/uploads/' . $request[$c]['portada'];
            }
        }
        return $request;
    }
}
