
<?php headerAdmin($data);?>

<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="bi bi-person-lines-fill"></i> <?= $data['page_title']?>
          <button class="btn btn-info" type="button"><i class="bi bi-plus-circle"></i></i></i>Nuevo</button>
        </h1>
          <p>Start a beautiful journey here</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
          <li class="breadcrumb-item"><a href="<?=base_url();?>/roles"><?= $data['page_title']?></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">Roles de usuario</div>
          </div>
        </div>
      </div>
    </main>
   
    <?php footerAdmin($data); ?>