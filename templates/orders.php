<?php
include 'header.php';
?>

<section id="aa-orders">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-orders-area">  
                    <h1>Детали заказа</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <form method="GET" action="/account/orders">
                                <label class="order-parameters-header">Номер заказа:</label>
                                <input class="form-control" type="number" maxlength="5" name="id" value="<?php if ($order->id) echo $order->id ?>">
                                <button class="green-button show-details" type="submit">Показать</button>
                            </form>
                            <?php
                            if ($order->id) {
                            ?>
                                <div><div class="order-parameters-header">Дата заказа:</div><div class="order-parameters-value"><?php echo strftime('%e/%m/%G', strtotime($order->date)); ?></div> </div>
                                <div><div class="order-parameters-header">Способ доставки:</div><div class="order-parameters-value"><?php echo $order->type; ?></div> </div>
                                <?php
                                if ($isadmin) {
                                ?>
                                    <div>
                                        <div class="order-parameters-header">Статус:</div>
                                        <select class="order-parameters-value form-control" id="status">
                                            <option value="1" <?php if ($order->status == "Принят") echo "selected"; ?>>Принят</option>
                                            <option value="2" <?php if ($order->status == "Исполняется") echo "selected"; ?>>Исполняется</option>
                                            <option value="3" <?php if ($order->status == "Подтвержден") echo "selected"; ?>>Потдвержден</option>
                                            <option value="4" <?php if ($order->status == "Не подтвержден") echo "selected"; ?>>Не подтвержден</option>
                                            <option value="5" <?php if ($order->status == "Выдан") echo "selected"; ?>>Выдан</option>
                                            <option value="6" <?php if ($order->status == "Изменение") echo "selected"; ?>>Изменение</option>
                                            <option value="7" <?php if ($order->status == "Не выдан") echo "selected"; ?>>Не выдан</option>
                                            <option value="8" <?php if ($order->status == "Отменен") echo "selected"; ?>>Отменен</option>
                                        </select>
                                    <button class="green-button show-details" id="change-order-status">Изменить</button>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div><div class="order-parameters-header">Статус:</div><div class="order-parameters-value"><span class="dotted" data-toggle="tooltip" title="<?php echo $order->statusdesc; ?>"><?php echo $order->status; ?></span></div></div>
                                <?php    
                                }
                                if ($order->id and $user->name and $order->profile == $user->name) {
                                ?>
                                    <div><div class="order-parameters-header">Сумма:</div><div class="order-parameters-value"><?php echo $order->total . " руб."; ?></div> </div>
                                    <?php
                                    if ($order->promo) {
                                    ?>
                                        <div><div class="order-parameters-header">Скидка:</div><div class="order-parameters-value"><?php echo $order->promo . " руб."; ?></div> </div>
                                    <?php
                                    }
                                    if ($order->bonus) {
                                    ?>
                                        <div><div class="order-parameters-header">Скидка:</div><div class="order-parameters-value"><?php echo $order->bonus . " руб."; ?></div> </div>
                                    <?php
                                    }
                                }    
                            } else {
                            ?>
                                <h4>Введите номер вашего заказа</h4>    
                            <?php        
                            }
                            ?>
                        </div>
                        <?php
                        if ($order->id and $user->name and $order->profile == $user->name) {
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