<?php
 class PlanesModel extends mysql
 {
     private $intIdplan;
     private $strNombre;
     private $strDescripcion;
     private $intTotalCupos;
     private $intPrecio;
     private $intCodigo;
     private $intStock;
     private $intIdCategoria;
     // private $intLIdLugar;
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
                        c.nombre as categoria,
                        p.precio,
                        p.stock,
                        p.status 
                 FROM planes p 
                 INNER JOIN categorias c
                 ON p.id_categoria = c.id_categoria
                 WHERE p.status != 0 ";
         $request = $this->select_all($sql);
         return $request;
     }
 }
 ?>
 
?>