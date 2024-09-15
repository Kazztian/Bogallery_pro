<?php
$orden = $data['pedido']['orden'];
$detalle = $data['pedido']['detalle'];
function formatDateAMPM($dateString)
{
    return date('d/m/Y h:i a', strtotime($dateString));
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Inscripción Plan - Bogallery</title>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
      color: #ccc;
    }

    .container-inscripcion {
      max-width: 900px;
      margin: 0 auto;
      background-color: #fff;
      padding: 10px;
      /* Reducido de 20px a 10px */
      border-radius: 10px;
      box-shadow: 0px 0px 10px 4px rgba(0, 0, 0, 0.1);
    }

    p {
      font-size: 15px;
      color: #555;
      text-align: center;
      line-height: 2;
      /* Reduce el espaciado entre líneas */
      margin: 5px 0;
      /* Reducir el margen superior e inferior */
    }

    h4 {
      font-size: 20px;
      /* Reducir el tamaño del texto */
      margin: 10px 0;
      /* Reducir el margen superior e inferior */
    }

    hr {
      border: 0;
      border-top: 1px solid #ccc;
      margin: 10px 0;
      /* Reducir el margen */
    }

    table {
      width: 100%;
      margin: 5px 0;
      /* Reducir el margen entre las tablas */
      border-collapse: collapse;
      background-color: #fafafa;
      border-radius: 8px;
      overflow: hidden;
    }

    table th,
    table td {
      padding: 8px;
      /* Reducir el padding en las celdas */
      font-size: 14px;
      /* Reducir el tamaño de fuente */
      color: #555;
    }

    table thead {
      background-color: #f0f0f0;
      font-weight: bold;
    }

    table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .logo {
      width: 200px;
      /* Reducir el tamaño del logo */
      height: auto;
    }

    @media screen and (max-width: 470px) {
      .logo {
        width: 80px;
      }

      p,
      table th,
      table td {
        font-size: 10px;
        /* Reducir el tamaño de fuente para pantallas pequeñas */
      }

      h4 {
        font-size: 16px;
      }
    }

    .total-row {
      background-color: #f0f0f0;
      font-weight: bold;
      padding: 8px;
      /* Reducir el padding en la fila de total */
    }
  </style>
</head>

<body>
  <div class="container-inscripcion">
    <p>
      Se ha generado una inscripción, a continuación encontrarás la información.
    </p>
    <hr>
    <table>
      <tr>
        <td width="33%">
          <img class="logo" src="<?= media(); ?>/tiendaBo/images/icons/logobo.png" alt="Logo Bogallery">
        </td>
        <td class="text-center" width="34%">
          <h4><?= NOMBRE_EMPRESA ?></h4>
          <p><?= DIRECCION ?><br> <?= TELEMPRESA ?><br> Email: <?= EMAIL_PLANES ?></p>
        </td>
        <td class="text-right" width="33%">
          <p>No. Orden: <strong><?= $orden['id_inscripcion'] ?></strong> <br> Fecha:<?= $orden['fecha'] ?>
            <?php
            if ($orden['idtipopago'] == 1) {


            ?>
              <br> Método Pago:<?= $orden['tipopago'] ?><br> Transacción:<?= $orden['idtransaccionpaypal'] ?>
            <?php
            } else { ?>
              Metodo de pago: Pago contra entrega <br>
              Tipo Pago:<?= $orden['tipopago'] ?>
            <?php
            }
            ?>

          </p>
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td width="140"><strong>Nombre:</strong></td>
        <td><?= $_SESSION['userData']['nombres'] . ' ' . $_SESSION['userData']['apellidos'] ?></td>
      </tr>
      <tr>
        <td><strong>Teléfono:</strong></td>
        <td><?= $_SESSION['userData']['telefono'] ?></td>
      </tr>
      <tr>
        <td><strong>Dirección del plan</strong></td>
        <td><?= $detalle[0]['direccion'] ?></td>
      </tr>
      <tr>
        <td><strong>Localidad del plan</strong></td>
        <td><?= $detalle[0]['localidad'] ?></td>
      </tr>
      <tr>
        <td><strong>Jornada</strong></td>
        <td><?= $detalle[0]['jornadap'] ?></td>
      </tr>
      <tr>
        <td><strong>Fecha de Inicio</strong></td>
        <td><?= formatDateAMPM($detalle[0]['fecha_inicio']) ?></td>
    </tr>
    <tr>
        <td><strong>Fecha Fin</strong></td>
        <td><?= formatDateAMPM($detalle[0]['fecha_fin']) ?></td>
    </tr>

    </table>
    <table>
      <thead>
        <tr>
          <th>Descripción</th>
          <th class="text-right">Precio</th>
          <th class="text-center">Cantidad</th>
          <th class="text-right">Importe</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (count($detalle) > 0) {
          $subtotal = 0;
        
          foreach ($detalle as $plan) {
            // Convertir el precio a número y calcular el importe
            $precio = floatval($plan['precio']);
            $importe = $precio * intval($plan['cantidad']);
        
            // Sumar el importe al subtotal
            $subtotal += $importe;
        
            // Formatear los valores para mostrarlos
            $precio_formateado = formatMoney($precio);
            $importe_formateado = formatMoney($importe);
        ?>
            <tr>
              <td><?= $plan['plan'] ?></td>
              <td class="text-right"><?= SMONEY . ' ' . $precio_formateado ?></td>
              <td class="text-center"><?= $plan['cantidad'] ?></td>
              <td class="text-right"><?= SMONEY . ' ' . $importe_formateado ?></td>
            </tr>
        <?php
          }
        
          // Calcular el IVA (19% del subtotal)
          $iva = $subtotal * COSTOENVIO;
        
          // Calcular el total redondeando para evitar problemas con PayPal
          $total = round($subtotal + $iva);
        
          // Formatear subtotal, IVA y total para mostrarlos correctamente
          $subtotal_formateado = formatMoney($subtotal);
          $iva_formateado = formatMoney($iva);
          $total_formateado = formatMoney($total);
        }
        ?>

        <!-- Mostrar los valores en el pie de la tabla -->
      <tfoot>
        <tr>
          <th colspan="3" class="text-right">Subtotal:</th>
          <td class="text-right"><?= SMONEY . ' ' . $subtotal_formateado ?></td>
        </tr>
        <tr>
          <th colspan="3" class="text-right">IVA (19%):</th>
          <td class="text-right"><?= SMONEY . ' ' . $iva_formateado ?></td>
        </tr>
        <tr class="total-row">
          <th colspan="3" class="text-right">Total:</th>
          <td class="text-right"><?= SMONEY . ' ' . $total_formateado ?></td>
        </tr>
      </tfoot>
    </table>
    <div class="text-center">
      <p>Si tiene alguna pregunta sobre su inscripción, <br> por favor póngase en contacto con nosotros a través de nuestro teléfono o correo electrónico.</p>
      <h4>¡Gracias por elegir Bogallery para su próxima aventura!</h4>
    </div>
  </div>
</body>

</html>