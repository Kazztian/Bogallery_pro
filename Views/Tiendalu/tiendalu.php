<?php
headerTiendabo($data);
getModal('modalCarrito', $data);
$arrLugares = $data['lugares']; // Asegúrate de que el controlador pase los lugares a la vista.
?>
<!-- Lugares -->
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
            for ($l = 0; $l < count($arrLugares); $l++) {
                $ruta = $arrLugares[$l]['ruta'];
                if (count($arrLugares[$l]['images']) > 0) {
                    $portada = $arrLugares[$l]['images'][0]['url_image'];
                } else {
                    $portada = media() . '/images/uploads/portada_categorias.jpg';
                }
            ?>
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="<?= $portada ?>" alt="<?= $arrLugares[$l]['nombre'] ?>">

                            <a href="<?= base_url() . '/tiendalu/detallelu/' . $arrLugares[$l]['id_lugar'] . '/' . $ruta; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                Ver lugar
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="<?= base_url() . '/tiendalu/detallelu/' . $arrLugares[$l]['id_lugar'] . '/' . $ruta; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    <?= $arrLugares[$l]['nombre'] ?>
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