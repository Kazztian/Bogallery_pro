<?php
headerTiendabo($data);
getModal('modalCarrito', $data);
$arrActividades = $data['actividades']; // Asegúrate de que el controlador pase los actividades a la vista.
?>
<!-- Actividades -->
<div class="bg0 m-t-23 p-b-140">
    <div class="container">
        <div class="flex-w flex-sb-m p-b-52">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                <h3><?= $data['page_title']; ?></h3>
            </div>


            <!-- Aquí puedes agregar los filtros si lo consideras necesario -->

        </div>

        <div class="row isotope-grid">
            <?php
            for ($a = 0; $a < count($arrActividades ); $a++) {
                $ruta = $arrActividades [$a]['ruta'];
                if (count($arrActividades [$a]['images']) > 0) {
                    $portada = $arrActividades[$a]['images'][0]['url_image'];
                } else {
                    $portada = media() . '/images/uploads/portada_categorias.jpg';
                }
            ?>
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="<?= $portada ?>" alt="<?= $arrActividades[$a]['nombre'] ?>">

                            <a href="<?= base_url() . '/tiendati/detalleti/' . $arrActividades[$a]['id_actividad'] . '/' . $ruta; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                Ver Actividad
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="<?= base_url() . '/tiendati/detalleti/' . $arrActividades[$a]['id_actividad'] . '/' . $ruta; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    <?= $arrActividades[$a]['nombre'] ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <!-- Load more -->
        <div class="flex-c-m flex-w w-full p-t-45">
            <a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                Cargar más
            </a>
        </div>
    </div>
</div>
<?php
footerTiendabo($data);
?>