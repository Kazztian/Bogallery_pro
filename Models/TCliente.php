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
    private   $strDireccion;
    private    $strPrimerI;
    private    $strSegundoI;
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
        string $direccion,
        string $primeri,
        string $segundoi,
        int $tipoid
    ) {
        // Se asignan los valores declarados en la parte superior 
        $this->con = new Mysql();
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->intEdad = $edad;
        $this->strDireccion = $direccion;
        $this->strPrimerI = $primeri;
        $this->strSegundoI = $segundoi;
        $this->intTipoId = $tipoid;
        $return = 0;
    
        // Validación para el email y saber si ya existe ese email
        $sql = "SELECT * FROM usuarios WHERE email_user = '{$this->strEmail}'";
        $request = $this->con->select_all($sql);
    
        // Si no hay registros con ese email, procede a la inserción
        if (empty($request)) {
            $query_insert = "INSERT INTO usuarios(
                nombres, apellidos, edad, telefono, email_user, password, direccion, primer_idioma, segundo_idioma, id_rol)  
                VALUES(?,?,?,?,?,?,?,?,?,?)";
    
            $arrData = array(
                $this->strNombre,
                $this->strApellido,
                $this->intEdad,
                $this->intTelefono,
                $this->strEmail,
                $this->strPassword,
                $this->strDireccion,
                $this->strPrimerI,
                $this->strSegundoI,
                $this->intTipoId
            );
    
            // Realiza la inserción y guarda el ID insertado en $request_insert
            $request_insert = $this->con->insert($query_insert, $arrData);
            $return = $request_insert; // Devuelve el ID si la inserción es correcta
        } else {
            $return = 0; // Indicar que el correo ya existe
        }
    
        return $return;
    }

    public function insertPedido(string $idtransaccionpaypal = NULL, string $datospaypal = NULL, int $idusuario, float $costo_iva, string $monto,  int $idtipopago, string $direccionenvio, string $status)
    {
        $this->con = new Mysql();
        $query_insert = "INSERT INTO inscripciones(idtransaccionpaypal, datospaypal, id_usuario, costo_iva, monto, idtipopago,direccion_envio, status)
                          VALUE(?,?,?,?,?,?,?,?)";

        $arrData = array(
            $idtransaccionpaypal,
            $datospaypal,
            $idusuario,
            $costo_iva,
            $monto,
            $idtipopago,
            $direccionenvio,
            $status
        );
        $request_insert = $this->con->insert($query_insert, $arrData);
        $return = $request_insert;
        return $return;
    }

    public function insertDetalle(int $idpedido, int $idplan, float $precio, int $cantidad)
    {
        $this->con = new Mysql();
        $query_insert = "INSERT INTO novedades(id_inscripcion,id_plan, precio, cantidad)
                         VALUE(?,?,?,?)";
        $arrData = array(
            $idpedido,
            $idplan,
            $precio,
            $cantidad
        );
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

        if (empty($request)) {
            foreach ($planes as $plan) {
                $query_insert = "INSERT INTO datalles_temp(precio, cantidad,idtransaccion, id_usuario, id_plan)
                                 VALUES(?,?,?,?,?)";
                $arrData = array(
                    $plan['precio'],
                    $plan['cantidad'],
                    $this->intIdTransaccion,
                    $this->intIdUsuario,
                    $plan['id_plan']
                );
                $request_insert = $this->con->insert($query_insert, $arrData);
            }
        } else {
            $sqlDel = "DELETE FROM datalles_temp WHERE
             idtransaccion = '{$this->intIdTransaccion}' AND
              id_usuario = $this->intIdUsuario";
            $request = $this->con->delete($sqlDel);

            foreach ($planes as $plan) {
                $query_insert = "INSERT INTO datalles_temp(precio, cantidad,idtransaccion, id_usuario, id_plan)
                                 VALUES(?,?,?,?,?)";
                $arrData = array(
                    $plan['precio'],
                    $plan['cantidad'],
                    $this->intIdTransaccion,
                    $this->intIdUsuario,
                    $plan['id_plan']
                );
                $request_insert = $this->con->insert($query_insert, $arrData);
            }
        }
    }

    public function getPedidio(int $idpedido)
    {

        $this->con = new Mysql();
        $request = array();
        $sql = "SELECT i.id_inscripcion,
                        i.referenciacobro,
                        i.idtransaccionpaypal,
                        i.id_usuario,
                        i.fecha,
                        i.costo_iva,
                        i.monto,
                        i.idtipopago,
                        t.tipopago,
                        i.direccion_envio,
                        i.status
        FROM inscripciones as i
        INNER JOIN tipopago t
        ON i.idtipopago = t.idtipopago
        WHERE i.id_inscripcion  = $idpedido";
        $requestPedidio = $this->con->select($sql);
        if (count($requestPedidio) > 0) {
            $sql_detalle = "SELECT p.id_plan,
            p.nombre AS plan,
            p.jornadap,
            p.fecha_inicio,
            p.fecha_fin,
            n.precio,
            n.cantidad,
            l.localidad,
            l.direccion
            FROM novedades n
            INNER JOIN planes p ON n.id_plan = p.id_plan
            INNER JOIN lugares l ON p.id_lugar = l.id_lugar
            WHERE n.id_inscripcion = $idpedido";

            // Ejecutar la consulta
            $requestPlanes = $this->con->select_all($sql_detalle);

            // Preparar la respuesta
            $request = array(
                'orden' => $requestPedidio,
                'detalle' => $requestPlanes
            );
        }
        return $request;
    }
}
