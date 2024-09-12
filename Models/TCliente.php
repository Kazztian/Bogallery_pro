<?php

//Primero Trait para extraer todas las categorias y se hace uso en el cotroller home
require_once("Libraries/Core/Mysql.php");
trait TCliente
{
    private $con;
    private    $intIdUsuario;
    private    $strNombre;
    private    $strApellido;
    private    $intTelefono;
    private    $strEmail;
    private    $strPassword;
    private    $intEdad;
    private    $strPrimerI;
    private     $strToken;
    private     $intTipoId;
    private  $intIdTransaccion;

    public function insertCliente(
        string $nombre,
        string $apellido,
        int $telefono,
        string $email,
        string $password,
        int $edad,
        string $primeri,
        int $tipoid

    ) {
        //Se asignan los valores declarados en la parte superior 
        $this->con = new Mysql();
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->intEdad = $edad;
        $this->strPrimerI = $primeri;
        $this->intTipoId = $tipoid;
        $return = 0;
        //Validacion para el email y saber si ya existe ese email
        $sql = "SELECT * FROM usuarios WHERE email_user = '{$this->strEmail}'";

        $request = $this->con->select_all($sql);
        /*Lo que hace $request es buscar y si no encuentra singun usuario con ese email 
deja registrar los datos del usuario  */
        if (empty($request)) {
            $query_insert = "INSERT INTO usuarios(
             nombres, apellidos, edad, telefono, email_user, password, primer_idioma, id_rol)  
              VALUES(?,?,?,?,?,?,?,?)";

            $arrData = array(

                $this->strNombre,
                $this->strApellido,
                $this->intEdad,
                $this->intTelefono,
                $this->strEmail,
                $this->strPassword,
                $this->strPrimerI,
                $this->intTipoId,
            );
            $request_insert = $this->con->insert($query_insert, $arrData);
            $request = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function insertPedido(string $idtransaccionpaypal = NULL, string $datospaypal = NULL, int $idusuario, string $monto, int $idtipopago, string $direccionenvio, string $status){
        $this->con = new Mysql();
        $query_insert = "INSERT INTO inscripciones(idtransaccionpaypal, datospaypal, id_usuario, monto, idtipopago,direccion_envio, status  )
                          VALUE(?,?,?,?,?,?,?)";
        
        $arrData = array($idtransaccionpaypal,
                          $datospaypal,
                          $idusuario,
                          $monto,
                          $idtipopago,
                          $direccionenvio,
                          $status);
        $request_insert = $this->con->insert($query_insert, $arrData);
        $return = $request_insert;
        return $return;

    }

    public function insertDetalle(int $idpedido, int $idplan, float $precio, int $cantidad){
        $this->con = new Mysql();
        $query_insert = "INSERT INTO novedades(id_inscripcion,id_plan, precio, cantidad)
                         VALUE(?,?,?,?)";
        $arrData = array($idpedido, 
                         $idplan,
                         $precio,
                         $cantidad);
        $request_insert = $this->con->insert($query_insert, $arrData);
        $return = $request_insert;
        return $return;
    }



    public function insertDetalleTemp(array $pedido)
    {
        $this->intIdUsuario = $pedido['idcliente'];
        $this->intIdTransaccion = $pedido['idtransaccion'];
        $planes = $pedido['planes'];
        $this->con = new Mysql();
        $sql = "SELECT * FROM datalles_temp WHERE
        idtransaccion = '{$this->intIdTransaccion}' AND
        id_usuario = $this->intIdUsuario";
                        $request = $this->con->select_all($sql);
        
        if(empty($request)){
            foreach ($planes as $plan){
                $query_insert = "INSERT INTO datalles_temp(precio, cantidad,idtransaccion, id_usuario, id_plan)
                                 VALUES(?,?,?,?,?)";
                $arrData = array( 
                    $plan['precio'],
                    $plan['cantidad'],
                    $this->intIdTransaccion,
                    $this->intIdUsuario,
                    $plan['id_plan']);
                $request_insert = $this->con->insert($query_insert, $arrData);
            }
        }else{
            $sqlDel = "DELETE FROM datalles_temp WHERE
             idtransaccion = '{$this->intIdTransaccion}' AND
              id_usuario = $this->intIdUsuario";
              $request = $this->con->delete($sqlDel);

              foreach ($planes as $plan){
                $query_insert = "INSERT INTO datalles_temp(precio, cantidad,idtransaccion, id_usuario, id_plan)
                                 VALUES(?,?,?,?,?)";
                $arrData = array( 
                    $plan['precio'],
                    $plan['cantidad'],
                    $this->intIdTransaccion,
                    $this->intIdUsuario,
                    $plan['id_plan']);
                $request_insert = $this->con->insert($query_insert, $arrData);
            }
        }

    }
}
