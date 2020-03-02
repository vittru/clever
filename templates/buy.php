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
                    <form action="/buy/complete" method="POST" id="order-form" onsubmit="//yaCounter44412517.reachGoal('ORDERYES'); return true;">
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
                                                            <input class="order-form form-control required" type="text" placeholder="Ваше имя*" name="name" value="<?php if ($_SESSION['user']->name) echo $_SESSION['user']->name; ?>">
                                                        </div>                             
                                                    </div>                            
                                                </div>  
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <input class="order-form form-control required" type="email" placeholder="Email*" name="email" value="<?php if ($_SESSION['user']->email) echo $_SESSION['user']->email; ?>">
                                                        </div>                             
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="aa-checkout-single-bill">
                                                            <input class="order-form form-control required" type="tel" placeholder="Телефон*" name="phone" value="<?php if ($_SESSION['user']->phone) echo $_SESSION['user']->phone; ?>">
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <ul class="nav nav-tabs aa-checkout-billaddress">
                                            <li class="active"><a href="#delivery" data-toggle="tab">Доставка</a></li>
                                            <!--li><a href="#pickup" data-toggle="tab">Самовывоз</a></li-->
                                        </ul>
                                        <div class="tab-content">
                                            <!--div class="tab-pane fade in" id="pickup">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="aa-checkout-single-bill">
                                                                <select name="branch" id="branch" class="form-control required">
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
                                                                <input class="order-form form-control" type="text" placeholder="Желаемая дата" name="takeDate">
                                                            </div>                             
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="aa-checkout-single-bill">
                                                                <input class="order-form form-control" type="text" placeholder="Желаемое время" name="takeTime">
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>
                                            </div-->
                                            <div class="tab-pane fade in active" id="delivery">
                                                <div class="panel-body">
                                                    <div class="row" id="delivery-info" <?php if ($total > $this->registry['freeDelivery']) echo "hidden" ?>>
                                                                <div class="col-md-12">
                                                                    Стоимость доставки по Самаре - 350<?php echo currency ?> 
                                                                </div>
                                                                <div class="col-md-12">
                                                                 Добавьте в заказ товаров на <span id="amount-left"><?php echo $this->registry['freeDelivery']-$total ?></span><?php echo currency ?>, и доставка будет бесплатной.
                                                                </div>  
                                                        <div id='freeDelivery' hidden><?php echo $this->registry['freeDelivery'] ?></div>
                                                            </div>    
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="aa-checkout-single-bill">
                                                                        Доставка курьером осуществляется только по городу Самара. В другие города мы доставляем транспортными компаниями.
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
                                    <div class="panel panel-default aa-checkout-billaddress">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                Пожелания по заказу
                                            </h4>
                                        </div>
                                        <div class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <textarea class="order-form form-control" cols="8" rows="2" name="remarks" placeholder="Комментарии и пожелания"></textarea>
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
                                                    $salegoods = false;
                                                    foreach ($_SESSION['cart'] as $cartItem) {
                                                        $good = $this->registry['model']->getGood($cartItem->goodId);
                                                        $size = $good->sizes[$cartItem->sizeId];
                                                ?>  
                        
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="aa-checkout-single-bill">
                                                            <?php echo $good->name ?><strong>&nbsp;&nbsp;x&nbsp;&nbsp;<?php echo $cartItem->quantity ?></strong>
                                                            <?php 
                                                            if ($cartItem->sale) {
                                                                echo "*";
                                                                $salegoods = true;
                                                            }    
                                                            ?>
                                                        </div>                             
                                                    </div>                            
                                                    <div class="col-md-4">
                                                        <div class="aa-checkout-single-bill">
                                                            <?php echo $cartItem->quantity * $cartItem->price . currency; ?>
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
                                                            <?php echo $total . currency ?>
                                                        </div>                             
                                                    </div>
                                                </div> 
                                                <?php    
                                                }
                                                ?>                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <ul class="nav nav-tabs aa-checkout-billaddress">
                                            <li class="active"><a href="#promoTab" data-toggle="tab">Промо</a></li>
                                            <?php
                                            if ($user->name and $user->bonus and $bonusAvailable) {
                                            ?>
                                            <li><a href="#bonusTab" data-toggle="tab">Бонус</a></li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active " id="promoTab">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="aa-checkout-single-bill">
                                                                <div id="promo-error" class="error" hidden></div>
                                                                <input type="text" placeholder="Промо-код" id="promo" name="promo" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($salegoods) {
                                                    ?>
                                                    <div class="aa-checkout-single-bill">Промо-коды не распространяются на товары помеченные *</div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                            if ($user->name and $user->bonus) {
                                            ?>
                                            <div class="tab-pane fade in" id="bonusTab">
                                                <div class="panel-body">
                                                    <div class="row">                                                                                            
                                                        <div class="col-md-12">
                                                            <div class="aa-checkout-single-bill">Всего бонусов: <?php echo $user->bonus ?></div>
                                                            <div class="aa-checkout-single-bill">Можно использовать: <?php echo min(1000, $totalNoSale, $user->bonus)?></div>
                                                            <div class="aa-checkout-single-bill">
                                                                <div id="bonus-error" class="error" hidden></div>
                                                                <input class="form-control" id="bonus" name="bonus" type="number" value="<?php echo min(1000, $totalNoSale, $user->bonus)?>">
                                                                <button id="use-bonus" class="orange button" type="button">Использовать</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($salegoods) {
                                                    ?>
                                                    <div class="aa-checkout-single-bill">Бонусы не распространяются на товары помеченные *</div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>    
                                            </div>   
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>  
                                    <div class="panel panel-default aa-checkout-billaddress">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                Способ оплаты
                                            </h4>
                                        </div>
                                        <div class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="aa-checkout-single-bill">
                                                            <label class="radio-inline"><input type="radio" name="payment" value="card" id="payment_card" checked style="width: auto;">Картой онлайн</label>
                                                            <label class="radio-inline"><input type="radio" name="payment" value="cash" id="payment_cash" style="width: auto;">Наличными при получении</label>
                                                        </div>                             
                                                    </div>                            
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div id="order-error" class="error" hidden>Не все обязательные поля заполнены</div>
                                    <input type="submit" value="Заказать и оплатить" class="green button" id='make_order'>                
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
