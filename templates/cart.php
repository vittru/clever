<?php
include 'header.php';
?>

<section id="cart-view">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="cart-view-area">
                    <div class="cart-view-table">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Товар</th>
                                        <th>Цена</th>
                                        <th>Количество</th>
                                        <th>Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td><img src="/images/goods/present.jpg" alt="img"></td>
                                        <td><a class="aa-cart-title">Ваш личный подарок от Экомаркет "Клевер"</a></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                    if (isset($_SESSION['cart'])){
                                        $total = 0;
                                        foreach ($_SESSION['cart'] as $cartItem) {
                                          $good = $this->registry['goods'][$cartItem->goodId];
                                          $size = $good->sizes[$cartItem->sizeId];
                                          $price = $size->getPrice($good->sale);
                                          $total = $total + $cartItem->quantity * $price;                              
                                    ?>
                                    <tr>
                                        <td><a class="aa-remove-product" id="<?php echo $cartItem->goodId; ?>" value="<?php echo $cartItem->sizeId; ?>"><fa class="fa fa-close"></fa></a></td>
                                        <td><img src="<?php echo $good->getImage() ?>" alt="img"></td>
                                        <td><a class="aa-cart-title"><?php echo $good->name ?> <?php echo $size->size ?></a></td>
                                        <td><?php echo $size->getWebPrice($good->sale) ?></td>
                                        <td><input class="aa-cart-quantity" type="number" value="<?php echo $cartItem->quantity ?>"></td>
                                        <td><?php echo $cartItem->quantity * $price.' руб.' ?></td>
                                    </tr>
                                    <?php
                                        }
                                    }    
                                    ?>
                                    <tr>
                                        <td colspan="5">Всего товаров на сумму:</td>
                                        <td><?php echo $total . ' руб.' ?></td>
                                    </tr>                      
                                    <tr>
                                        <td colspan="6" class="aa-cart-view-bottom">
                                            <?php
                                            if ($total) {
                                            ?>
                                              <a href="/buy"><input class="aa-cart-view-btn" type="submit" value="Оформить заказ"></a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </tbody>  
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
include 'footer.php';