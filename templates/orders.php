<?php
include 'header.php';
?>

<section id="aa-orders">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-orders-area">  
                    <div class="row">
                        <h1>Детали заказа</h1>
                        <div class="col-md-12">
                            <form method="GET" action="/account/orders">
                                <label class="order-parameters-header">Номер заказа:</label>
                                <input class="form-control" type="number" maxlength="5" name="id" value="<?php if ($order->id) echo $order->id ?>">
                                <button class="green-button show-details" type="submit">Показать</button>
                            </form>
                            <?php
                            if ($order->id) {
                            ?>    
                                <div><div class="order-parameters-header">Дата заказа:</div><div class="order-parameters-value"><?php echo $order->date; ?></div> </div>
                                <div><div class="order-parameters-header">Способ доставки:</div><div class="order-parameters-value"><?php echo $order->type; ?></div> </div>
                                <div><div class="order-parameters-header">Статус:</div><div class="order-parameters-value"><?php echo $order->status; ?></div></div>
                                <div><div class="order-parameters-header">Сумма:</div><div class="order-parameters-value"><?php echo ($order->total-$order->promo) . " руб."; ?></div> </div>
                                <?php
                                if ($order->promo) {
                                ?>
                                    <div><div class="order-parameters-header">Промо-скидка:</div><div class="order-parameters-value"><?php echo $order->promo . " руб."; ?></div> </div>
                                <?php
                                }
                            } else {
                            ?>
                                <h4>Введите номер вашего заказа</h4>    
                            <?php        
                            }
                            ?>
                        </div>
                        <?php
                        if ($order->id and $user->name) {
                        ?>
                        <div class="col-md-12">
                            <h2>Товары</h2>
                            <table class="table">
                                <tr>
                                    <th>Название</th>
                                    <th>Количество</th>
                                    <th>Цена</th>
                                </tr>
                                <?php 
                                foreach ($order->goods as $goodO) {
                                ?>
                                <tr>
                                    <td><a class="btn" href="/showgood?id=<?php echo $goodO->id ?>"><?php echo $goodO->name ?> <?php echo $goodO->size ?></a></td>
                                    <td><?php echo $goodO->quantity ?></td>
                                    <td><?php echo $goodO->price ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="3"></td>
                                </tr>
                            </table>    
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>    

<?php
include 'footer.php';