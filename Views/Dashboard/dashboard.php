<?php headerAdmin($data); ?>

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-speedometer"></i><?= $data['page_title'] ?></h1>
            <p>Start a beautiful journey here</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Blank Page</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">dashboard</div>

            </div>
            <?php 
            // Importante para depurar los datos
                // $requestApi= CurlConnectionGet(URLPAYPAL."/v2/checkout/orders/9DB712837V528204V","application/json",getTokenPaypal());
                // dep($requestApi);
                // $requestPost =CurlConnectionPost(URLPAYPAL."/v2/payments/captures/54704019MB476104G/refund","application/json",getTokenPaypal());
                // dep($requestPost);
            
            ?>
        </div>
    </div>
</main>

<?php footerAdmin($data); ?>