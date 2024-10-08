<!-- Footer -->
<footer class="bg3 p-t-75 p-b-32">
	<div class="container">
		<div class="row">
			<!-- Categorias -->
			<div class="col-sm-6 col-lg-4 p-b-50">
				<h4 class="stext-301 cl0 p-b-30">
					Categorias
				</h4>
				<ul>
					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
						Underground
						</a>
					</li>

					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
						Curiosidades
						</a>
					</li>

					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
						Deportes y Recreación
						</a>
					</li>

					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
						Aventura y Acción
						</a>
					</li>
					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
						Gastronomía y mercados
						</a>
					</li>
					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
						Socializar y Amigos
						</a>
					</li>
					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
						Historia y Patrimonio
						</a>
					</li>
					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
						Cultura y Arte
						</a>
					</li>
					<li class="p-b-10">
						<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
						Vida Nocturna
						</a>
					</li>
				</ul>
			</div>
			<!-- Contactoooo -->
			<div class="col-sm-6 col-lg-4 p-b-50">
				<h4 class="stext-301 cl0 p-b-30">
					CONTACTO
				</h4>

				<p class="stext-107 cl7 size-201">
					<?= DIRECCION?>
					<br>
					Tel: <a class="linkFooter" href="tel:<?=TELEMPRESA?>"><?=TELEMPRESA?></a><br>
					Email: <a class="linkFooter" href="mailo:<?=EMAIL_PLANES?>"><?=EMAIL_PLANES?></a>
				</p>
				<!-- Redes sociales -->
				<div class="p-t-27">
					<!-- El target blanck sirve para que se abra en una nueva pestaña -->
					<a href="<?=FACEBOOK?>" target="_blanck" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
						<i class="fa fa-facebook"></i>
					</a>

					<a href="<?=INSTAGRAM?>" target="_blanck" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
						<i class="fa fa-instagram"></i>
					</a>
					<a href="https://wa.me/<?=WHATASPP?>" target="_blanck" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
						<i class="fa fa-whatsapp"></i>
					</a>
					
				</div> 
				<br>
				<h4 class="stext-301 cl0 p-b-30">Derechos de Autor</h4>
    
    <!-- Descripción del autor -->
    <p class="stext-107 cl7 size-201">
        Autor de las fotografías tomadas
    </p>

    <!-- Información de contacto por email -->
    <p class="stext-107 cl7 size-201">
        Email: <a class="linkFooter" href="mailto:<?=EMAIL_FO?>"><?=EMAIL_FO?></a>
    </p>

    <!-- Redes sociales -->
    <div class="social-links p-t-27">
        <a href="<?=IGFOTOS?>" target="_blank" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
            <i class="fa fa-instagram"></i>
        </a>
    </div>
			</div>

			
			<!-- Subscripcion -->
			<div class="col-sm-6 col-lg-4 p-b-50">
				<h4 class="stext-301 cl0 p-b-30">
					Suscribete
				</h4>

				<form>
					<div class="wrap-input1 w-full p-b-4">
						<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
						<div class="focus-input1 trans-04"></div>
					</div>

					<div class="p-t-18">
						<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
							Suscribirme
						</button>
					</div>
				</form>
			</div>
		</div>

		<div class="p-t-40">
			<!-- Icono del medio de pago PAYPAL -->
			<div class="flex-c-m flex-w p-b-18">
				<a href="#" class="m-all-1">
					<img src="<?= media() ?>/tiendaBo/images/icons/icon-pay-01.png" alt="ICON-PAY">
				</a>
			</div>
			<!-- Derechos de Autor -->
			<p class="stext-107 cl6 txt-center">
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
				<?= NOMBRE_EMPRESA; ?> | <a href="https://colorlib.com" target="_blanck">Colorlib</a>
				<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

			</p>
		</div>
	</div>
</footer>


<!-- Back to top -->
<div class="btn-back-to-top" id="myBtn">
	<span class="symbol-btn-back-to-top">
		<i class="zmdi zmdi-chevron-up"></i>
	</span>
</div>

<script>
	const base_url = "<?= base_url(); ?>";
	const smony = "<?= SMONEY; ?>";
</script>

<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/vendor/bootstrap/js/popper.js"></script>
<script src="<?= media() ?>/tiendaBo/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/vendor/select2/select2.min.js"></script>

<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/vendor/daterangepicker/moment.min.js"></script>
<script src="<?= media() ?>/tiendaBo/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/vendor/slick/slick.min.js"></script>
<script src="<?= media() ?>/tiendaBo/js/slick-custom.js"></script>
<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/vendor/parallax100/parallax100.js"></script>

<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>

<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/vendor/sweetalert/sweetalert.min.js"></script>

<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!--===============================================================================================-->
<script src="<?= media() ?>/tiendaBo/js/main.js"></script>
<script src="<?= media() ?>/js/functions_admin.js"></script>
<script src="<?= media() ?>/js/functions_login.js"></script>
<script src="<?= media() ?>/tiendaBo/js/functions.js"></script>

</body>

</html>