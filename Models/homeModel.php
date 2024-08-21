<?php
//require_once("CategoriasModel.php"); //Hacen una instacion de categorias model  para usar un metodo 
class HomeModel extends mysql
{
  private $objCategoria;
  public function __construct()
  {
    parent::__construct();
    //$this->objCategoria = new CategoriasModel();
  }

  public function getCategoriasT()
  {
    //return $this->objCategoria->selectCategorias();

  }
}
