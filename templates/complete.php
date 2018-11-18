<?php
include 'header.php';
?>
<?php
if ($payment) {
?>
    <script src="https://securepay.tinkoff.ru/html/payForm/js/tinkoff.js" defer></script>
    <script src="/js/payment.min.js" defer></script>
<?php
} else {
?>
    <script src="/js/pause.js"></script>
<?php    
}
?>


<section class="aa-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="order-confirm" hidden>
                    <div hidden id="pay_order"><?php echo $orderId; ?></div>
                    <div hidden id="pay_sum"><?php echo $sum * 100; ?></div>
                    <div hidden id="pay_name"><?php echo $user->name; ?></div>
                    <div hidden id="pay_email"><?php echo $user->email; ?></div>
                    <div hidden id="pay_phone"><?php echo $user->phone; ?></div>
                    <h1 class="center">Номер вашего заказа: <?php echo $orderId; ?></h1>
                    <p class="center">Наш менеджер свяжется с Вами в ближайшее время, чтобы уточнить детали</p>
                    <p></p>
                    <?php
                    if ($bonus) {
                    ?>
                        <p></p>
                        <p class="center">За этот заказ Вы получили новые бонусные баллы: <?php echo $bonus ?></p>
                    <?php
                    }
                    ?>
                    <p></p>
                    <h4 class="center">Спасибо за шоппинг с нами.</h4>
                    <h4 class="center">Ваш Клевер!</h4>
                </div>  
                <div id="payment-redirect">
                    <?php if ($payment) { ?>
                        <h1 class="center">Перенаправляем Вас на сайт Тинькофф Банк для оплаты заказа</h1>
                    <?php } else { ?>
                        <h1 class="center">Мы обрабатываем ваш заказ</h1>
                    <?php } ?>    
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        <span>Пожалуйста, подождите немного</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>    

<?php
include 'footer.php';
