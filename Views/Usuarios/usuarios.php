<?php
headerAdmin($data);
getModal('modalUsuarios', $data);
?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-person-lines-fill"></i> <?= $data['page_title'] ?>
                <button class="btn btn-info" type="button" onclick="openModal();"><i class="bi bi-plus-circle"></i></i></i>Nuevo</button>
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
                        <table class="table table-hover table-bordered" id="tableUsuarios">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombres</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Rol</th>
                                    <th>Status</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Carlos</td>
                                    <td>rrrr</td>
                                    <td>juan@</td>
                                    <td>454444</td>
                                    <td>Administrador</td>
                                    <td>Activos</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

<?php footerAdmin($data); ?>