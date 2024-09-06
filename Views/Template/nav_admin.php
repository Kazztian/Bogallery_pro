<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media(); ?>/images/avatar.png" alt="User Image">
    <div>
      <p class="app-sidebar__user-name"><?= $_SESSION['userData']['nombres']; ?></p>
      <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['nombrerol']; ?></p>
    </div>
  </div>
  <!--  -->
  <ul class="app-menu">
    <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
      <li>
        <a class="app-menu__item" href="<?= base_url(); ?>/dashboard">
          <i class="app-menu__icon bi bi-speedometer"></i>
          <span class="app-menu__label">Dashboard</span>
        </a>
      </li>
    <?php } ?>
    <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
      <li class="treeview">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon bi bi-people-fill"></i>
          <span class="app-menu__label">Usuarios</span>
          <i class="treeview-indicator bi bi-chevron-right"></i>
        </a>
        <ul class="treeview-menu">
          <li><a class="treeview-item" href="<?= base_url(); ?>/usuarios"><i class="icon bi bi-circle-fill"></i> Usuarios</a></li>
          <li><a class="treeview-item" href="<?= base_url(); ?>/roles"><i class="icon bi bi-circle-fill"></i> Roles</a></li>


        </ul>
      </li>
    <?php } ?>
    <!--  -->
    <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
      <li>
        <a class="app-menu__item" href="<?= base_url(); ?>/clientes">
          <i class="app-menu__icon bi bi-person-fill-check"></i>
          <span class="app-menu__label">Clientes</span>
        </a>
      </li>
    <?php } ?>
    <!--  -->
    <?php if (!empty($_SESSION['permisos'][4]['r']) || !empty($_SESSION['permisos'][6]['r']) || !empty($_SESSION['permisos'][7]['r'])) { ?>
      <li class="treeview">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon bi bi-signpost-split-fill"></i>
          <span class="app-menu__label">Turismo</span>
          <i class="treeview-indicator bi bi-chevron-right"></i>
        </a>
        <ul class="treeview-menu">
          <?php if (!empty($_SESSION['permisos'][7]['r'])) { ?>
            <li><a class="treeview-item" href="<?= base_url(); ?>/planes"><i class="icon bi bi-circle-fill"></i>Planes</a></li>
          <?php } ?>
          <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
            <li><a class="treeview-item" href="<?= base_url(); ?>/categorias"><i class="icon bi bi-circle-fill"></i>Categorias</a></li>
          <?php } ?>
          <li><a class="treeview-item" href="<?= base_url(); ?>/novedades"><i class="icon bi bi-circle-fill"></i>Novedad</a></li>
          <li><a class="treeview-item" href="<?= base_url(); ?>/promociones"><i class="icon bi bi-circle-fill"></i>Promocion</a></li>
        </ul>
      </li>
    <?php } ?>
    <!--  -->
    <?php if (!empty($_SESSION['permisos'][5]['r']) || !empty($_SESSION['permisos'][8]['r']) || !empty($_SESSION['permisos'][9]['r']) ) { ?>
      <li class="treeview">
        <a class="app-menu__item" href="#" data-toggle="treeview">
          <i class="app-menu__icon bi bi-journal-richtext"></i>
          <span class="app-menu__label">Historia</span>
          <i class="treeview-indicator bi bi-chevron-right"></i>
        </a>
        <ul class="treeview-menu">
        <?php if (!empty($_SESSION['permisos'][8]['r'])) { ?>
          <li><a class="treeview-item" href="<?= base_url(); ?>/lugares"><i class="icon bi bi-circle-fill"></i>Lugar</a></li>
          <?php } ?>
          <?php if (!empty($_SESSION['permisos'][9]['r'])) { ?>
          <li><a class="treeview-item" href="<?= base_url(); ?>/actividades"><i class="icon bi bi-circle-fill"></i>Actividades</a></li>
          <?php } ?>
          <li><a class="treeview-item" href="<?= base_url(); ?>/audiorelatos"><i class="icon bi bi-circle-fill"></i>Audio-Relato</a></li>
        </ul>
      </li>
    <?php } ?>

    <!--  -->
    <li><a class="app-menu__item" href="<?= base_url(); ?>/logout">
        <i class="app-menu__icon bi bi-box-arrow-right"></i>
        <span class="app-menu__label">Logout</span>
      </a>
    </li>
  </ul>
</aside>