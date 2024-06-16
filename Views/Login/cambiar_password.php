<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Juan y Estefa">
    <script src="https://kit.fontawesome.com/a5375fbf32.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="<?= media(); ?>/images/favicon.ico">
    <meta name="theme-color" content="#009688">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/login.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
    <title><?= $data['page_tag']; ?></title>
</head>
<body>
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content">
        <div class="logo">
            <h1><?= $data['page_title']; ?></h1>
        </div>
        <!--Formulario Recuperar Contraseña  -->
        <div id="login-box" class="login-box flipped">
            <form id="formCambiarPass" name="formCambiarPass" class="forget-form" action="">
                <input type="hidden" id="id_usuario" name="id_usuario" value="<?= $data['id_usuario']; ?>" required>
                <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email']; ?>" required>
                <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token']; ?>" required>
                <h3 id="login-head" class="login-head"><i class="fas fa-key"></i>Cambiar Contraseña</h3>
                <div class="mb-3">
                    <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Nueva Contraseña" required>
                </div>
                <div class="mb-3">
                    <input id="txtPasswordConfirm" name="txtPasswordConfirm" class="form-control" type="password" placeholder="Confirmar Contraseña" required>
                </div>
                <div class="mb-3 btn-container d-grid">
                    <button type="submit" class="btn btn-primary btn-block"><i class="bi bi-unlock me-2 fs-5"></i>RESTABLECER</button>
                </div>
            </form>
        </div>
    </section>
    <script>
        const base_url = "<?= base_url(); ?>"
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.7.0.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>
