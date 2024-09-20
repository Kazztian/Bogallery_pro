<?php
$canCarrito = 0;
if (isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0) {
	foreach ($_SESSION['arrCarrito'] as $planct) {
		$canCarrito += $planct['cantidad'];
	}
}
//dep($_SESSION['userData']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title><?= $data['page_tag']; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?= media() ?>/tiendaBo/images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/fonts/linearicons-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/vendor/slick/slick.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/vendor/MagnificPopup/magnific-popup.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/vendor/perfect-scrollbar/perfect-scrollbar.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= media() ?>/tiendaBo/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
	<!--===============================================================================================-->
</head>

<body class="animsition">
<div class="modal fade" id="modalAyuda" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="mtext-111 cl2 p-b-16">Preguntas Frecuentes</h3>
                <div class="accordion" id="faqAccordion">
                    
                    <!-- Pregunta 1 -->
                    <div class="card">
                        <div class="card-header" id="faqHeading1">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1">
                                    ¿Las fechas de los planes ya están establecidas por la empresa?
                                </button>
                            </h5>
                        </div>
                        <div id="faq1" class="collapse" aria-labelledby="faqHeading1" data-parent="#faqAccordion">
                            <div class="card-body">
                                Sí, las fechas de los planes turísticos ya están establecidas por la empresa, y los usuarios pueden inscribirse dentro de los plazos indicados para cada plan.
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 2 -->
                    <div class="card">
                        <div class="card-header" id="faqHeading2">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                    ¿Las actividades que se muestran son pagas?
                                </button>
                            </h5>
                        </div>
                        <div id="faq2" class="collapse" aria-labelledby="faqHeading2" data-parent="#faqAccordion">
                            <div class="card-body">
                                No, las actividades que se muestran en nuestra plataforma no son pagas, simplemente ofrecemos información sobre ellas para que los usuarios las conozcan y puedan planificar sus visitas.
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 3 -->
                    <div class="card">
                        <div class="card-header" id="faqHeading3">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                    ¿Es necesario crear una cuenta para hacer un pago?
                                </button>
                            </h5>
                        </div>
                        <div id="faq3" class="collapse" aria-labelledby="faqHeading3" data-parent="#faqAccordion">
                            <div class="card-body">
                                Sí, es necesario crear una cuenta en nuestro sistema para poder realizar pagos y gestionar la inscripción a planes turísticos.
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 4 -->
                    <div class="card">
                        <div class="card-header" id="faqHeading4">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#faq4" aria-expanded="false" aria-controls="faq4">
                                    ¿Se pueden inscribir a dos planes el mismo día?
                                </button>
                            </h5>
                        </div>
                        <div id="faq4" class="collapse" aria-labelledby="faqHeading4" data-parent="#faqAccordion">
                            <div class="card-body">
                                Sí, es posible inscribirse en dos planes el mismo día, siempre que el cliente tenga en cuenta los horarios y que ambos planes no se superpongan. Es importante respetar las fechas y horas establecidas para cada plan para garantizar una experiencia óptima.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

	 <div id="divLoading">
		<div>
			<img src="<?= media(); ?>/images/loading.svg" alt="Loading">
		</div>
	</div>
	<!-- Header -->
	<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						<?php if (isset($_SESSION['login'])) { ?>
							Bienvenido a BoGallery: <?= $_SESSION['userData']['nombres'] . ' ' . $_SESSION['userData']['apellidos'] ?>
						<?php } ?>
					</div>

					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m trans-04 p-lr-25" data-toggle="modal" data-target="#modalAyuda">
							Ayuda y preguntas frecuentes <!-- Crear una pagina sobre preguntas precuentes -->
							<?php
							if(isset($_SESSION['login'])){

							
							
							?>
						</a>

						<a href="<?=base_url()?>/dashboard" class="flex-c-m trans-04 p-lr-25">
							Mi cuenta
						</a>
						<?php
							}  if(isset($_SESSION['login'])){
								
								?>
						<a href="<?= base_url()?>/logout" class="flex-c-m trans-04 p-lr-25">
							Salir
						</a>
						<?php }else{?>
							<a href="<?= base_url()?>/login" class="flex-c-m trans-04 p-lr-25">
						   Iniciar sesion
						</a>
						<?php }?>
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">

					<!-- Logo desktop -->
					<a href="<?= base_url(); ?>" class="logo">
						<img src="<?= media() ?>/tiendaBo/images/icons/logobo.png" alt="Logo-BoGallery">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="<?= base_url(); ?>">Inicio</a>

							</li>
							<li>
								<a href="<?= base_url(); ?>/tiendabo">Planes</a>
							</li>
							<li>
								<a href="<?= base_url(); ?>/tiendalu">Lugares</a>
							</li>
							<li>
								<a href="<?= base_url(); ?>/tiendati">Actividades</a>
							</li>


							<li>
								<a href="<?= base_url(); ?>/carrito">Carrito</a>
							</li>

							<li>
								<a href="<?= base_url(); ?>/nosotros">Nosotros</a>
							</li>

							<li>
								<a href="<?= base_url(); ?>/contacto">Contacto</a>
							</li>
						</ul>
					</div>

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>
						<?php if ($data['page_name'] != "carrito" and $data['page_name'] != "procesarpago") { ?>
							<div class="cantCarrito icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="<?= $canCarrito; ?>">
								<i class="zmdi zmdi-shopping-cart"></i>
							</div>
						<?php } ?>
					</div>
				</nav>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->
			<div class="logo-mobile">
				<a href="<?= base_url(); ?>"><img src="<?= media() ?>/tiendaBo/images/icons/logobo.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>
				<?php if ($data['page_name'] != "carrito" and $data['page_name'] != "procesarpago") { ?>
					<div class="cantCarrito icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="<?= $canCarrito; ?>">
						<i class="zmdi zmdi-shopping-cart"></i>
					</div>
				<?php } ?>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>
		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
					<?php if (isset($_SESSION['login'])) { ?>
							Bienvenido a BoGallery: <?= $_SESSION['userData']['nombres'] . ' ' . $_SESSION['userData']['apellidos'] ?>
						<?php } ?>
					</div>
				</li>
				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m p-lr-10 trans-04"  data-toggle="modal" data-target="#modalAyuda">
							Ayuda y preguntas frecuentes
							<?php
							if(isset($_SESSION['login'])){
							?>
						</a>
						<a href="<?=base_url()?>/dashboard" class="flex-c-m p-lr-10 trans-04">
							Mi cuenta
						</a>
						<?php
							}  if(isset($_SESSION['login'])){
								
								?>
						<a href="<?= base_url()?>/logout" class="flex-c-m p-lr-10 trans-04">
							Salir 
						</a>
						<?php }else{?>
							<a href="<?= base_url()?>/login" class="flex-c-m trans-04 p-lr-25">
						   Iniciar sesion
						</a>
						<?php }?>
					</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="<?= base_url(); ?>">Inicio</a>
					<!-- <ul class="sub-menu-m">
						<li><a href="index.html">Homepage 1</a></li>
						<li><a href="home-02.html">Homepage 2</a></li>
						<li><a href="home-03.html">Homepage 3</a></li>
					</ul> -->
					<!-- <span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span> -->
				</li>

				<li>
					<a href="<?= base_url(); ?>/tiendabo">Planes</a>
				</li>
				<li>
					<a href="<?= base_url(); ?>/carrito">Carrito</a>
				</li>
				<li>
					<a href="<?= base_url(); ?>/tiendalu">Lugares</a>
				</li>
				<li>
					<a href="<?= base_url(); ?>/tiendati">Actividades</a>
				</li>

				<li>
					<a href="<?= base_url(); ?>/nosotros">Nosotros</a>
				</li>

				<li>
					<a href="<?= base_url(); ?>/contacto">Contacto</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="<?= media() ?>/tiendaBo/images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Tu carrito
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>

			<div id="productosCarrito" class="header-cart-content flex-w js-pscroll">
				<?php getModal('modalCarrito', $data); ?>
			</div>
		</div>
	</div>