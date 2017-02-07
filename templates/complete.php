<?php
include 'header.php';

if ($payment) {
?>
    <script src="https://securepay.tinkoff.ru/html/payForm/js/tinkoff.js" defer></script>
    <script src="/js/payment.js" defer></script>
<?php
}
?>


<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-product-header">
                    <div id="order-confirm">
                        <div hidden id="pay_order"><?php echo $orderId; ?></div>
                        <div hidden id="pay_sum"><?php echo $sum * 100; ?></div>
                        <div hidden id="pay_name"><?php echo $user->name; ?></div>
                        <div hidden id="pay_email"><?php echo $user->email; ?></div>
                        <div hidden id="pay_phone"><?php echo $user->phone; ?></div>
                        <h1>Номер вашего заказа: <?php echo $orderId; ?></h1>
                        <p>Наш менеджер свяжется с Вами в ближайшее время, чтобы уточнить детали</p>
                        <p></p>
                        <?php
                        if ($bonus) {
                        ?>
                            <p></p>
                            <p>За этот заказ Вы получили новые бонусные баллы: <?php echo $bonus ?></p>
                        <?php
                        }
                        ?>
                        <p></p>
                        <p>Спасибо за шоппинг с нами.</p>
                        <h4>Ваш Клевер!</h4>
                    </div>  
                    <div id="payment-redirect" hidden>
                        <h1>Перенаправляем Вас на сайт оплаты</h1>
                        <progress max="100"></progress>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>    

<?php
include 'footer.php';
