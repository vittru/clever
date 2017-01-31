<?php
include 'header.php';
?>

<!-- Cart view section -->
<section id="checkout">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Оформление заказа</h1>
                <div class="checkout-area">
                    <form action="/buy/complete" method="POST" id="order-form">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="checkout-left">
                                    <div class="panel panel-default aa-checkout-billaddress">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                Ваши данные
                                            </h4>
                                        </div>
                                        <div class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <input class="order-form form-control" type="text" placeholder="Ваше имя*" name="name" value="<?php if ($_SESSION['user']->name) echo $_SESSION['user']->name; ?>">
                                                        </div>                             
                                                    </div>                            
                                                </div>  
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <input class="order-form form-control" type="email" placeholder="Email*" name="email" value="<?php if ($_SESSION['user']->email) echo $_SESSION['user']->email; ?>">
                                                        </div>                             
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <input class="order-form form-control" type="tel" placeholder="Телефон*" name="phone" value="<?php if ($_SESSION['user']->phone) echo $_SESSION['user']->phone; ?>">
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default aa-checkout-billaddress">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                                        Самовывоз
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseFour" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="aa-checkout-single-bill">
                                                                <select name="branch" id="branch" class="form-control">
                                                                    <option value="0" disabled selected>Выберите точку*</option>
                                                                    <?php
                                                                    foreach ($this->registry['branches'] as $id=>$branch) {
                                                                    ?>
                                                                        <option value="<?php echo $id ?>"><?php echo $branch->address ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>                             
                                                        </div>                            
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="aa-checkout-single-bill">
                                                                <input class="order-form form-control" type="text" placeholder="Желаемая дата*" name="takeDate">
                                                            </div>                             
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="aa-checkout-single-bill">
                                                                <input class="order-form form-control" type="text" placeholder="Желаемое время*" name="takeTime">
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default aa-checkout-billaddress">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                                        Доставка курьером
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseThree" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="row" id="delivery-info" <?php if ($total > $this->registry['freeDelivery']) echo "hidden" ?>>
                                                        <div class="col-md-12">
                                                            Стоимость доставки по Самаре - 300 руб. 
                                                        </div>
                                                        <div class="col-md-12">
                                                            Добавьте в заказ товаров на <span id="amount-left"><?php echo $this->registry['freeDelivery']-$total ?></span> руб., и доставка будет бесплатной.
                                                        </div>  
                                                        <div id='freeDelivery' hidden><?php echo $this->registry['freeDelivery'] ?></div>
                                                    </div>    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="aa-checkout-single-bill">
                                                                <input class="order-form form-control" type="text" placeholder="Населенный пункт*" name="city">
                                                            </div>                             
                                                        </div>                            
                                                    </div>  
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="aa-checkout-single-bill">
                                                                <textarea class="order-form form-control" cols="8" rows="2" name="address" placeholder="Адрес*"></textarea>
                                                            </div>                             
                                                        </div>                            
                                                    </div>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        </div>
                                                        </div>                             
                            <div class="col-md-4">
                                <div class="checkout-right">
                                    <div class="panel panel-default aa-checkout-billaddress">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                    Ваши товары 
                                            </h4>
                                        </div>  
                                        <div class="panel-collapse collapse in checkout-goods">
                                            <div class="panel-body">
                                                <?php
                                                if (isset($_SESSION['cart'])){
                                                  foreach ($_SESSION['cart'] as $cartItem) {
                                                    $good = $this->registry['model']->getGood($cartItem->goodId);
                                                    $size = $good->sizes[$cartItem->sizeId];
                                                    $price = $size->getPrice($good->sale);
                                                ?>  
                        
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="aa-checkout-single-bill">
                                                            <?php echo $good->name." ".$size->size; ?><strong>&nbsp;&nbsp;x&nbsp;&nbsp;<?php echo $cartItem->quantity ?></strong>
                                                        </div>                             
                                                    </div>                            
                                                    <div class="col-md-4">
                                                        <div class="aa-checkout-single-bill">
                                                            <?php echo $cartItem->quantity * $price . " руб."; ?>
                                                        </div>                             
                                                    </div>
                                                </div> 
                                                <?php
                                                  }
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-12">-------------</div>
                                                </div>  
                                                <div class="row" hidden id="discount">
                                                    <div class="col-md-8">
                                                        <div class="aa-checkout-single-bill">
                                                            <strong>Скидка</strong>
                                                        </div>                             
                                                    </div>                            
                                                    <div class="col-md-4">
                                                        <div class="aa-checkout-single-bill" id="sum">
                                                        </div>                             
                                                    </div>
                                                </div>                            
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="aa-checkout-single-bill">
                                                            <strong>Общая сумма</strong>
                                                        </div>                             
                                                    </div>                            
                                                    <div class="col-md-4">
                                                        <div class="aa-checkout-single-bill" id="total">
                                                            <?php echo $total . " руб." ?>
                                                        </div>                             
                                                    </div>
                                                </div> 
                                                <?php    
                                                }
                                                ?>                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-group" id="accordionRight">
                                        <div class="panel panel-default aa-checkout-billaddress">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <?php
                                                    if ($user->name and $user->bonus) {
                                                    ?>    
                                                    <a data-toggle="collapse" data-parent="#accordionRight" href="#collapsePromo">
                                                    <?php 
                                                    }
                                                    ?>    
                                                        Промо-код
                                                    <?php
                                                    if ($user->name and $user->bonus) {
                                                    ?>    
                                                    </a>
                                                    <?php 
                                                    }
                                                    ?>    
                                                </h4>
                                            </div>
                                            <div id="collapsePromo" class="panel-collapse collapse in">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="promo-error" class="error" hidden></div>
                                                            <input type="text" placeholder="Промо-код" id="promo" name="promo" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        if ($user->name and $user->bonus) {
                                        ?>
                                        <div class="panel panel-default aa-checkout-billaddress">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordionRight" href="#collapseBonus" id="panel-bonus">Бонусы</a>
                                                </h4>
                                            </div>  
                                            <div id="collapseBonus" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="row">                                                                                            
                                                        <div class="col-md-12">
                                                            <div class="aa-checkout-single-bill">Всего бонусов: <?php echo $user->bonus ?></div>
                                                            <div class="aa-checkout-single-bill">Можно использовать: <?php echo min(floor($total * 0.3), $user->bonus)?></div>
                                                            <div id="bonus-error" class="error" hidden></div>
                                                            <input class="form-control" id="bonus" name="bonus" type="number" value="<?php echo min(floor($total * 0.3), $user->bonus)?>">
                                                            <button id="use-bonus" class="orange-button" type="button">Использовать</button>
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>    
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div id="order-error" class="error" hidden>Не все обязательные поля заполнены</div>
                                    <input type="submit" value="Заказать" class="green-button">                
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';