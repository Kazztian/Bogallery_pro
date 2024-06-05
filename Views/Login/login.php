<!DOCTYPE html>
<html lang="es">
  <head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Juan y estefa">
  <script src="https://kit.fontawesome.com/a5375fbf32.js" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="<?=media();?>/images/favicon.ico">
  <meta name="theme-color" content="#009688">
 
  <link rel="stylesheet" type="text/css" href="<?=media();?>/css/login.css">
  <link rel="stylesheet" type="text/css" href="<?=media();?>/css/main.css">
 
  
 
  <title><?php $data['page_tag  ']; ?></title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
      <h1>BoGallery</h1>
      </div>
      <div id="login-box" class="login-box">
        <form class="login-form" action="index.html">
          <h3 id="login-head" class="login-head"><i class="bi bi-person me-2"></i>Inicio Sesion</h3>
          <div class="mb-3">
            <label id="form-label" class="form-label">USUARIO</label>
            <input  id="txtEmail" id="form-control" class="form-control" type="email" placeholder="Email" autofocus>
          </div>
          <div class="mb-3">
            <label id="form-label" class="form-label">CONTRASEÑA</label>
            <input id="txtPassword" id="form-control" class="form-control" type="password" placeholder="Contraseña">
          </div>
          <div class="mb-3">
            <div class="utility">
              
              <p id="semibold-text mb-2" class="semibold-text mb-2"><a href="#"  class="forgot-password" data-toggle="flip">¿Olvido su Contraseña?</a></p>
            </div>
          </div>
          <div id="alertLogin" class="text-center"></div>
              <div class="mb-3 btn-container d-grid">
               <button type="submit" class="btn btn-primary btn-block"><i class="bi bi-box-arrow-in-right"></i> INICIAR SESIÓN</button>
          </div>
        </form>
        <form class="forget-form" action="index.html">
          <h3 id="login-head" class="login-head"><i class="bi bi-person-lock me-2"></i>¿Has olvidado tu contraseña?</h3>
          <div class="mb-3">
            <label id="form-label" class="form-label">EMAIL</label>
            <input id="txtEmailReset" id="form-control"  class="form-control" type="text" placeholder="Email">
          </div>
          <div class="mb-3 btn-container d-grid">
            <button type="submit" class="btn btn-primary btn-block"><i class="bi bi-unlock me-2 fs-5"></i>REINICIAR</button>
          </div>
          <div class="mb-3 mt-3">
            <p id="semibold-text mb-0" class="semibold-text mb-0">
                <a href="#" class="back-to-login" data-toggle="flip"><i class="bi bi-chevron-left me-1"></i> Iniciar sesión</a>
            </p>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.7.0.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <script src="<?= media(); ?>/js/<?=$data['page_functions_js'];?>"></script>
    <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  </body>
</html>