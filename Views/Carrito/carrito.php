<?php
headerTiendabo($data);
?>
<br><br><br>
<br>
<!-- breadcrumb -->
<div class="container">
	<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
		<a href="<?= base_url() ?>" class="stext-109 cl8 hov-cl1 trans-04">
			Inicio
			<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
		</a>

		<span class="stext-109 cl4">
			<?= $data['page_title'] ?>
		</span>
	</div>
</div>
<!-- Variables de secion para ver la cantidad de carritos en el carrito-->
<?php
$subtotal = 0;
$total = 0;
$iva = 0; // Declaramos la variable para el IVA
if (isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0) {
?>
	<!-- Shoping Cart -->
	<form class="bg0 p-t-75 p-b-85">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
					<div class="m-l-25 m-r--38 m-lr-0-xl">
						<div class="wrap-table-shopping-cart">
							<table id="tblCarrito" class="table-shopping-cart">
								<tr class="table_head">
									<th class="column-1">Planes</th>
									<th class="column-2"></th>
									<th class="column-3">Precio</th>
									<th class="column-4">Cantidad</th>
									<th class="column-5">Total</th>
								</tr>
								<?php
								foreach ($_SESSION['arrCarrito'] as $plan) {
									$totalPlan = $plan['precio'] * $plan['cantidad'];
									$subtotal += $totalPlan;
									$idPlan = openssl_encrypt($plan['id_plan'], METHODENCRIPT, KEY);
								?>
									<tr class="table_row <?= $idPlan ?>">
										<td class="column-1">
											<div class="how-itemcart1" idpl="<?= $idPlan ?>" op="2" onclick="fntdelItem(this)">
												<img src="<?= $plan['imagen'] ?>" alt="<?= $plan['plan'] ?>">
											</div>
										</td>
										<td class="column-2"><?= $plan['plan'] ?></td>
										<td class="column-3"><?= SMONEY . formatMoney($plan['precio']) ?></td>
										<td class="column-4">
											<div class="wrap-num-product flex-w m-l-auto m-r-0">
												<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" idpl="<?= $idPlan ?>">
													<i class="fs-16 zmdi zmdi-minus"></i>
												</div>

												<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1" value="<?= $plan['cantidad'] ?>" idpl="<?= $idPlan ?>">

												<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" idpl="<?= $idPlan ?>">
													<i class="fs-16 zmdi zmdi-plus"></i>
												</div>
											</div>
										</td>
										<td class="column-5"><?= SMONEY . formatMoney($totalPlan) ?></td>
									</tr>
								<?php } ?>
							</table>
						</div>
					</div>
				</div>

				<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
					<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
						<h4 class="mtext-109 cl2 p-b-30">
							Totales
						</h4>

						<div class="flex-w flex-t bor12 p-b-13">
							<div class="size-208">
								<span class="stext-110 cl2">
									Subtotal
								</span>
							</div>

							<div class="size-209">
								<span id="subTotalCompra" class="mtext-110 cl2">
									<?= SMONEY . formatMoney($subtotal) ?>
								</span>
							</div>

							<div class="size-208">
								<span class="stext-110 cl2">
									IVA (19%)
								</span>
							</div>

							<div class="size-209">
								<?php
								$iva = $subtotal * COSTOENVIO; // Aplicamos el 19% de IVA al subtotal
								?>
								<span class="mtext-110 cl2">
									<?= SMONEY . formatMoney($iva) ?>
								</span>
							</div>

						</div>

						<div class="flex-w flex-t p-t-27 p-b-33">
							<div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
							</div>

							<div class="size-209 p-t-1">
								<?php
								$total = $subtotal + $iva; // Sumamos el subtotal más el IVA para obtener el total
								?>
								<span id="totalCompra" class="mtext-110 cl2">
									<?= SMONEY . formatMoney($total) ?>
								</span>
							</div>
						</div>

						<a href="<?= base_url() ?>/carrito/procesarpago" id="btnComprar" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
							Procesar pago
						</a>
					</div>
				</div>
			</div>
		</div>
	</form>
<?php } else { ?>

	<br>
	<div class="container">
		<p>
			No hay planes en el carrito <a href="<?= base_url() ?>/Tiendabo/plan">Ver Planes</a>
		</p>
	</div>

<?php
}
footerTiendabo($data);
?>