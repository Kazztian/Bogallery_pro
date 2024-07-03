<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 5, SASS y PUG.js. Es completamente personalizable y modular.">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Juan Sebastian Madrid, Esthefania Narvaez">
  <meta name="theme-color" content="#009688">
  <link rel="shortcut icon" href="<?= media(); ?>/images/favicon.ico">
  <title><?= $data['page_tag'] ?></title>
  <!-- Main CSS -->
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.min.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
  <!-- Bootstrap Icons CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Font Awesome Icons CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="app sidebar-mini">
<div id="divLoading" >
      <div>
        <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
      </div>
    </div>
  <!-- Navbar -->
  <header class="app-header">
    <a class="app-header__logo" href="<?= base_url(); ?>/dashboard">BoGallery</a>
    <!-- Sidebar toggle button -->
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu -->
    <ul class="app-nav">
      <!-- User Menu -->
      <li class="dropdown">
        <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">
          <i class="bi bi-person fs-4"></i>
        </a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          <li><a class="dropdown-item" href="<?= base_url(); ?>/opciones"><i class="bi bi-gear me-2 fs-5"></i> Configuraciones</a></li>
          <li><a class="dropdown-item" href="<?= base_url(); ?>/usuarios/perfil"><i class="bi bi-person me-2 fs-5"></i> Perfil</a></li>
          <li><a class="dropdown-item" href="<?= base_url(); ?>/logout"><i class="bi bi-box-arrow-right me-2 fs-5"></i> Logout</a></li>
        </ul>
      </li>
    </ul>
  </header>
  <?php require_once("nav_admin.php"); ?>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Font Awesome JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
