<?php
 class RolesModel extends mysql{

  public $intIdrol;
  public $strRol;
  public $strDescripcion;
  public $intStatus;
  



    function __construct()
    {

      parent::__construct();
    }

    public function selectRoles()
    {
      $whereAdmin = "";
      if($_SESSION['idUser'] != 1)
      {
        $whereAdmin = " and id_rol != 1";
      }
        $sql = "SELECT * FROM rol WHERE status !=0".$whereAdmin;
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectRol(int $idrol)
    {
      $this->intIdrol = $idrol;
      $sql="SELECT * FROM rol WHERE id_rol = $this->intIdrol";
      $request = $this->select($sql);
      return $request;
    }

//Agregar un rol
    public function insertRol(string $rol,string $descripcion,int $status){
      $return = "";
      $this->strRol = $rol;
      $this->strDescripcion =$descripcion;
      $this->intStatus = $status;
  
      $sql ="SELECT * FROM rol WHERE nombrerol = '{$this->strRol}'";
      $request = $this->select_all($sql);

      //Validacion para saber si ya existe ese rol
      if(empty($request))
      {
          $query_insert = "INSERT INTO rol(nombrerol, descripcion, status) VALUES (?, ?, ?)";
          $arrData = array($this->strRol, $this->strDescripcion,$this->intStatus);
          $request_insert = $this->insert($query_insert,$arrData);
          $return = $request_insert;
      }else{
          $return = 0;
      }
      return $return;
  } 

  //Actualizar un rol
      public function updateRol(int $idrol, string $rol, string $descripcion, int $status){
        $this->intIdrol = $idrol;
        $this->strRol = $rol;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        $sql =  "SELECT * FROM rol WHERE nombrerol = '$this->strRol' AND id_rol !=$this->intIdrol";
        $request = $this->select_all($sql);
        if(empty($request))
        {
          $sql = "UPDATE rol SET nombrerol = ?, descripcion = ?, status=? where id_rol =$this->intIdrol";
          $arrData = array($this->strRol,$this->strDescripcion,$this->intStatus);
          $request = $this->update($sql,$arrData);

        }else{
          $request = 0;
        }
        return $request;
        }

    //Eliminar/Delete rol 
      public function deleteRol(int $idrol)
      {
        $this->intIdrol = $idrol;
        $sql ="SELECT * FROM usuarios WHERE id_rol = $this->intIdrol";
        $request = $this->select_all($sql);
        if(empty($request))
        {
            $sql = "UPDATE rol SET status = ? WHERE id_rol = $this->intIdrol";//Se realiza un update para guardar los registros 
            $arrData = array(0); //y tienen un estado 0
            $request = $this -> update($sql, $arrData);
            if($request)
            {
              $request= 'ok';
            }else{
              $request = 'error';
            }
        }else{
          $request = 'exist';
        }
        return $request;

      }
 
 }

?>