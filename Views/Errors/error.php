
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
  <title>Página no encontrada</title>
  <!-- Aquí puedes agregar tu enlace a las fuentes de Google -->
</head>
<body id="error-page">
  <div class="error_container">
    <div class="error_code">
      <p>4</p>
      <p>0</p>
      <p>4</p>
    </div>
    <div class="error_title">Página no encontrada</div>
    <div class="error_description">No se pudo encontrar esta página</div>
    <a class="btn btn-primary btn-lg custom-btn" href="<?= base_url(); ?>/dashboard" role="button">Regresar</a>

  </div>
</body>
</html>