<?php
headerTiendabo($data);
getModal('modalCarrito', $data);
$arrLugar = $data['lugar'];
$arrLugares = $data['lugares'];
$arrImages = $arrLugar['images'];
?>
<br><br><br>
<!-- breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="<?= base_url(); ?>" class="stext-109 cl8 hov-cl1 trans-04">
            Inicio
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <!-- <a href="product.html" class="stext-109 cl8 hov-cl1 trans-04">

            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a> -->

        <span class="stext-109 cl4">
            <?= $arrLugar['nombre']; ?>
        </span>
    </div>
</div>


<!-- Product Detail -->
<section class="sec-product-detail bg0 p-t-65 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-7 p-b-30">
                <div class="p-l-25 p-r-30 p-lr-0-lg">
                    <div class="wrap-slick3 flex-sb flex-w">
                        <div class="wrap-slick3-dots"></div>
                        <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                        <div class="slick3 gallery-lb">
                            <?php if (!empty($arrImages)) { ?>
                                <?php for ($img = 0; $img < count($arrImages); $img++) { ?>
                                    <div class="item-slick3" data-thumb="<?= $arrImages[$img]['url_image']; ?>">
                                        <div class="wrap-pic-w pos-relative">
                                            <img src="<?= $arrImages[$img]['url_image']; ?>" alt="<?= $arrLugar['nombre'] ?>">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?= $arrImages[$img]['url_image']; ?>">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 p-b-30">
                <div class="p-r-50 p-t-5 p-lr-0-lg">
                    <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                        <?= $arrLugar['nombre']; ?>
                    </h4>
                    <br>
                    <h5 class="mtext-105 cl2 js-name-detail p-b-14">
                        localidad:<?= $arrLugar['localidad']; ?>
                    </h5>
                    <h5 class="mtext-105 cl2 js-name-detail p-b-14">
                        Direccion:<?= $arrLugar['direccion']; ?>
                    </h5>

                    <!--  -->
                    <div class="flex-w flex-m p-l-100 p-t-40 respon7">

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bor10 m-t-50 p-t-43 p-b-40">
            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item p-b-10">
                        <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Descripcion</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content p-t-43">
                    <!-- Descripcion- -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="how-pos2 p-lr-15-md">
                            <p class="stext-102 cl6">
                                <?= $arrLugar['descripcion']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
        <h3 class="ltext-106 cl5 txt-center">> Explora nuevos lugares <</h3>
    </div>
</section>


<!-- Related Products -->
<section class="sec-relate-product bg0 p-t-45 p-b-105">
    <div class="container">
        <!-- Slide2 -->
        <div class="wrap-slick2">
            <div class="slick2">
                <?php
                if (!empty($arrLugares)) {
                    for ($l = 0; $l < count($arrLugares); $l++) {
                        $ruta = $arrLugares[$l]['ruta'];
                        if (count($arrLugares[$l]['images']) > 0) {
                            $portada = $arrLugares[$l]['images'][0]['url_image'];
                        } else {
                            $portada = media() . '/images/uploads/portada_categorias.jpg';
                        }
                ?>
                        <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src="<?= $portada ?>" alt="<?= $arrLugares[$l]['nombre']; ?>">

                                    <a href="<?= base_url() . '/tiendalu/detallelu/' . $arrLugares[$l]['id_lugar'] . '/' . $ruta; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                        Explorar Lugar
                                    </a>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="<?= base_url() . '/tiendalu/detallelu/' . $arrLugares[$l]['id_lugar'] . '/' . $ruta; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            <?= $arrLugares[$l]['nombre']; ?>
                                        </a>

                                        <span class="stext-105 cl3">
                                            <?= $arrLugares[$l]['tipo_lugar']; ?>
                                        </span>
                                    </div>

                                    <div class="block2-txt-child2 flex-r p-t-3">
                                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                            <img class="icon-heart1 dis-block trans-04" src="<?= media() ?>/tiendaBo/images/icons/icon-heart-01.png" alt="ICON">
                                            <img class="icon-heart2 dis-block trans-04 ab-t-l" src="<?= media() ?>/tiendaBo/images/icons/icon-heart-02.png" alt="ICON">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php
footerTiendabo($data);
?>