<?php
headerTiendabo($data);
?>
<br><br><br>
<br>
<div class="jumbotron text-center">
  <h1 class="display-4">¡Gracias por tu compra!</h1>
  <p class="lead">Tu plan fue procesado con éxito.</p>
  <p>No. compra: <strong> <?= $data['orden']; ?> </strong></p>

  <?php 
   if(!empty($data['transaccion'])){
  ?>
   <p>Transacción: <strong> <?= $data['transaccion']; ?> </strong></p>
   <?php } ?>
 
  <hr class="my-4">
  <p>Puedes ver el estado de tu plan en la sección inscripciones de tu usuario.</p>
  <br>
  <a class="btn btn-primary btn-lg" href="<?= base_url(); ?>" role="button">Continuar</a>
</div>

<?php

footerTiendabo($data);
?>