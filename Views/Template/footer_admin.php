<script>
  const base_url = "<?= base_url(); ?>";
</script>
<!-- Essential javascripts for application to work-->
<script src="<?= media(); ?>/js/jquery-3.7.0.min.js"></script>
<script src="<?= media(); ?>/js/popper.min.js"></script>

<script src="<?= media(); ?>/js/bootstrap.min.js"></script>

<script src="<?= media(); ?>/js/main.js"></script>
<script src="<?= media(); ?>/js/plugins/pace.js"></script>
<script src="<?= media(); ?>/js/functions_admin.js"></script>
<script type="text/javascript" src="<?= media(); ?>js/plugins/sweetalert.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css">



<!-- Data table plugin-->
<script type="text/javascript" src="<?= media(); ?>/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?= media(); ?>/js/plugins/bootstrap-select.min.js"></script>

<!--Aque lo que se hace es una condicion para abrir la pagina
   seleccionada-->
<?php if ($data['page_name'] == "rol_usuario") { ?>
  <script src="<?= media(); ?>/js/functions_roles.js"></script>
<?php } ?>
<?php if ($data['page_name'] == "usuarios") { ?>
  <script src="<?= media(); ?>/js/functions_usuarios.js"></script>
<?php } ?>
<!-- Page specific javascripts-->
<!-- Google analytics script-->

</body>

</html>