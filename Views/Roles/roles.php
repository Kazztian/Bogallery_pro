<?php
headerAdmin($data);
getModal('modalRoles', $data);
?>
<div id="contentAjax"></div>

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-person-fill-exclamation"></i> <?= $data['page_title'] ?>
        <?php if ($_SESSION['permisosMod']['w']) { ?>
          <button class="btn btn-success" type="button" onclick="openModal();"><i class="bi bi-plus-circle"></i></i></i>Nuevo</button>
        <?php } ?>
      </h1>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>/roles"><?= $data['page_title'] ?></a></li>
    </ul>
  </div>
  </div>
  <!-- Datatable -->
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tableRoles">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Status</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>

<?php footerAdmin($data); ?>