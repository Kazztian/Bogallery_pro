<?php
headerTiendabo($data);
$banner = media() . "/tiendabo/images/bg-01.png"
?>
<script>
	document.querySelector('header').classList.add('header-v4');
</script>

<!-- Title page -->
<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url(<?= $banner ?>);">
	<h2 class="ltext-105 cl0 txt-center">
		Nosotros
	</h2>
</section>

<!-- Content page -->
<section class="bg0 p-t-75 p-b-120">
	<div class="container">
		<div class="row p-b-148">
			<div class="col-md-7 col-lg-8">
				<div class="p-t-7 p-r-85 p-r-15-lg p-r-0-md">
					<h3 class="mtext-111 cl2 p-b-16">
						Nuestra Historia
					</h3>
					<p class="stext-113 cl6 p-b-26">
						En Bogallery, somos un equipo apasionado de dos estudiantes con un sueño en común: revitalizar y promover el vibrante turismo en Bogotá y sus alrededores. Nuestra misión es ofrecerte una ventana única a los rincones más sorprendentes y diversos de la ciudad, llevándote más allá de los típicos destinos turísticos.

						Nuestra Historia
						Bogallery nació de la inquietud y la creatividad de dos estudiantes comprometidos con el enriquecimiento cultural y la exploración local. Al observar la riqueza cultural y la diversidad de Bogotá, decidimos unir nuestras habilidades y conocimientos para crear una plataforma que no solo resalte los lugares más icónicos, sino que también descubra joyas ocultas y experiencias auténticas.
					</p>

					<p class="stext-113 cl6 p-b-26">
						"En Colombia hay que hacer muchas cosas. Aquí siempre hay algo por hacer, pero no siempre se hace bien."
					</p>
				</div>
			</div>

			<div class="col-11 col-md-5 col-lg-4 m-lr-auto">
				<div class="how-bor1 ">
					<div class="hov-img0">
						<img src="Assets/images/avatar.png" alt="Avatar Image">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="order-md-2 col-md-7 col-lg-8 p-b-30">
				<div class="p-t-7 p-l-85 p-l-15-lg p-l-0-md">
					<h3 class="mtext-111 cl2 p-b-16">
						Nuestra Mision
					</h3>
					<p class="stext-113 cl6 p-b-26">
						<strong>Nuestra Misión</strong> 
						<br>
						Queremos inspirarte a explorar Bogotá de una manera nueva. Desde la vibrante vida nocturna hasta los rincones ocultos llenos de historia, nuestro objetivo es ofrecerte información detallada, recomendaciones personalizadas y experiencias inolvidables. Creemos que cada rincón de Bogotá tiene una historia que contar, y queremos ser tu guía para descubrirlas todas.
						<br>

						<strong> ¿Qué Ofrecemos?</strong>
						<br>
						Guías y Recomendaciones: Información completa sobre los mejores lugares para visitar, desde los más conocidos hasta los más escondidos.
						<br>
						Experiencias Únicas: Descubre actividades y eventos que capturan la esencia de la ciudad.
						<br>

						<strong>Únete a Nosotros <br>
						Te invitamos a formar parte de nuestra comunidad y a descubrir lo mejor de Bogotá con nosotros. Síguenos en nuestras redes sociales y suscríbete a nuestras actualizaciones para no perderte ninguna novedad.</strong>
						<br>

						En Bogallery, estamos emocionados de compartir esta aventura contigo. ¡Explora, descubre y enamórate de Bogotá como nunca antes!
					</p>



					<div class="bor16 p-l-29 p-b-9 m-t-22">
						<p class="stext-114 cl6 p-r-40 p-b-11">
						El arte no es lo que ves, sino lo que haces que otros vean.
						</p>

						<span class="stext-111 cl8">
							- Colombia
						</span>
					</div>
				</div>
			</div>

			<div class="order-md-1 col-11 col-md-5 col-lg-4 m-lr-auto p-b-30">
				<div class="how-bor2">
					<div class="hov-img0">
						<img src="Assets/images/mision.png" alt="Avatar Image">
					</div>
				</div>
			</div>
		</div>
		<br>
		<hr>
		<br>

		<!-- Video Section: Para el Administrador y Uso General Lado a Lado -->
		<div class="row">
			<div class="col-md-6 text-center">
				<h3 class="mtext-111 cl2 p-b-16">Video Tutorial - Administrador</h3>
				<iframe width="100%" height="315" src="https://www.youtube.com/embed/fQkLOAsEPyM?si=wrS64uAR2QZd3qqL" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
			</div>
			<div class="col-md-6 text-center">
				<h3 class="mtext-111 cl2 p-b-16">Video Tutorial - Uso de la Página</h3>
				<iframe width="100%" height="315" src="https://www.youtube.com/embed/u6JNerGqd0Y?si=8qkV3uKA2rR5M-jJ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</section>
<?php
footerTiendabo($data);
?>