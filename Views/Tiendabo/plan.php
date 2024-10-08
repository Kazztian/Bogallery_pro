<?php
headerTiendabo($data);
$arrPlan = $data['plan']; //Extraer la info del plan (Son variables, que extraen de los array)
$arrPlanes = $data['planes']; //Extraer la info de los planes
$arrImages = $arrPlan['images']; //Extrae todas la imagenes de ese plan
$rutacategoria = $arrPlan['id_categoria'] . '/' . $arrPlan['ruta_categoria'];
$rutalugar = $arrPlan['id_lugar'] . '/' . $arrPlan['ruta_lugar'];
$rutacategoria = $arrPlan['id_categoria'] . '/' . $arrPlan['ruta_categoria'];
function formatDateAMPM($dateString)
{
    return date('d/m/Y h:i a', strtotime($dateString));
}
?>
<br><br><br>
<br>
<!-- Parte superior -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="<?= base_url(); ?>" class="stext-109 cl8 hov-cl1 trans-04">
            Inicio
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <a href="<?= base_url() . '/tiendalu/detallelu/' . $rutalugar; ?>" class="stext-109 cl8 hov-cl1 trans-04">
            <?= $arrPlan['lugar'] ?>
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <a href="<?= base_url() . '/tiendabo/categoria/' . $rutacategoria; ?>" class="stext-109 cl8 hov-cl1 trans-04">
            <?= $arrPlan['categoria'] ?>
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>


        <span class="stext-109 cl4">
            <?= $arrPlan['nombre'] ?>
        </span>
    </div>
</div>

<!-- Detalle del plan -->
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
                                            <img src="<?= $arrImages[$img]['url_image']; ?>" alt="<?= $arrPlan['nombre'] ?>">

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
                    <!-- Nombre del Plan (más grande) -->
                    <h1 class="mtext-105 cl2 js-name-detail p-b-14">
                        <strong><?= $arrPlan['nombre'] ?></strong>
                    </h1>

                    <!-- Precio del Plan -->
                    <h1 class="mtext-105 cl2 p-b-14">
                        <strong>Precio: </strong> <br><?= SMONEY . formatMoney($arrPlan['precio']); ?>
                    </h1>

                    <!-- Información del Plan -->
                    <div class="plan-info p-t-20">
                        <h3 class="mtext-108 cl2 p-b-14">
                            <strong>Jornada:</strong> <?= $arrPlan['jornadap'] ?>
                        </h3>
                        <h3 class="mtext-108 cl2 p-b-14">
                            <strong>Fecha Inicio:</strong><br><?= formatDateAMPM($arrPlan['fecha_inicio']) ?>
                        </h3>
                        <h3 class="mtext-108 cl2 p-b-14">
                            <strong>Fecha Fin:</strong> <br><?= formatDateAMPM($arrPlan['fecha_fin']) ?>
                        </h3>
                    </div>

                    <!-- Agregar al carrito -->
                    <br>
                    <div class="flex-w flex-r-m p-b-10">
                        <div class="size-204 flex-w flex-m respon6-next">
                            <!-- Verificar si hay stock disponible -->
                            <?php if ($arrPlan['stock'] > 0) { ?>
                                <!-- Selector de Cantidad -->
                                <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                    </div>

                                    <input id="cant-product" class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1" min="1" max="<?= $arrPlan['stock']; ?>">

                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                </div>
                                <br>

                                <!-- Botón de Agregar al Carrito -->
                                <button id="<?= openssl_encrypt($arrPlan['id_plan'], METHODENCRIPT, KEY); ?>" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                    Agrega al carrito
                                </button>
                            <?php } else { ?>
                                <!-- Mensaje de stock agotado -->
                                <div class="alert alert-danger" role="alert">
                                   Se agotaron los cupos disponibles para este plan.
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <!--  -->
                    <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                        <div class="flex-m bor9 p-r-10 m-r-11">
                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
                                <i class="zmdi zmdi-favorite"></i>
                            </a>
                        </div>
                        <!-- Iconos de las redes sociales -->
                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
                            <i class="fa fa-twitter"></i>
                        </a>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
                            <i class="fa fa-google-plus"></i>
                        </a>
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
                                    <?= $arrPlan['descripcion']; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
            <h3 class="ltext-106 cl5 txt-center">> Planes Relacionados <</h3>
        </div>
</section>

<!-- Planes Relacionados -->
<section class="sec-relate-product bg0 p-t-45 p-b-105">
    <div class="container">

        <!-- Slide2 -->
        <div class="wrap-slick2">
            <div class="slick2">
                <?php
                if (!empty($arrPlanes)) {
                    for ($p = 0; $p < count($arrPlanes); $p++) {
                        $ruta = $arrPlanes[$p]['ruta'];
                        //Se valida que si el producto no tiene imagenes cola esa imagen por defecto
                        if (count($arrPlanes[$p]['images']) > 0) {
                            $portada = $arrPlanes[$p]['images'][0]['url_image'];
                        } else {
                            $portada = media() . '/images/uploads/portada_categorias.jpg';
                        }

                ?>
                        <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src="<?= $portada ?>" alt=" <?= $arrPlanes[$p]['nombre'] ?>">

                                    <a href="<?= base_url() . '/tiendabo/plan/' . $arrPlanes[$p]['id_plan'] . '/' . $ruta; ?>" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                        Ver Planes
                                    </a>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="<?= base_url() . '/tiendabo/plan/' . $arrPlanes[$p]['id_plan'] . '/' . $ruta; ?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            <?= $arrPlanes[$p]['nombre'] ?>
                                        </a>

                                        <span class="stext-105 cl3">
                                            <?= SMONEY . formatMoney($arrPlanes[$p]['precio']); ?>
                                        </span>
                                    </div>

                                    <div class="block2-txt-child2 flex-r p-t-3">
                                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                            <img class="icon-heart1 dis-block trans-04" src="<?= media() ?>/tiendabo/images/icons/icon-heart-01.png" alt="ICON">
                                            <img class="icon-heart2 dis-block trans-04 ab-t-l" src="<?= media() ?>/tiendabo/images/icons/icon-heart-02.png" alt="ICON">
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