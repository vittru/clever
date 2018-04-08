<?php
include 'header.php';
?>

<section id="cart-view">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Корзина</h1>
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
                                        <td><div class="aa-cart-title"><?php
                                            if ($total >= $this->registry['presentSum'])
                                                echo 'Ваш личный подарок от Экомаркет "Клевер"';
                                            else
                                                echo 'Оформите заказ на ' . $this->registry['presentSum'] . ' рублей и получите подарок';
                                            ?>
                                            </div></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                    if (isset($_SESSION['cart'])){
                                        foreach ($_SESSION['cart'] as $cartItem) {
                                          $good = $this->registry['model']->getGood($cartItem->goodId);
                                          $size = $good->sizes[$cartItem->sizeId];
                                    ?>
                                    <tr>
                                        <td><a class="aa-remove-product" id="<?php echo $cartItem->goodId; ?>" value="<?php echo $cartItem->sizeId; ?>"><fa class="fa fa-times"></fa></a></td>
                                        <td><a href="/showgood?id=<?php echo $good->id ?>"><img src="<?php echo $good->getImage() ?>" alt="<?php echo $good->name ?>"></a></td>
                                        <td><a class="aa-cart-title" href="/showgood?id=<?php echo $good->id ?>"><?php echo $good->name ?> <?php echo $size->size ?></a></td>
                                        <td><?php echo $cartItem->price ?></td>
                                        <td><input class="aa-cart-quantity form-control" type="number" value="<?php echo $cartItem->quantity ?>"></td>
                                        <td><?php echo $cartItem->quantity * $cartItem->price . currency ?></td>
                                    </tr>
                                    <?php
                                        }
                                    }    
                                    ?>
                                    <tr>
                                        <td colspan="5">Всего товаров на сумму:</td>
                                        <td><?php echo $total . currency ?></td>
                                    </tr>                      
                                    <tr>
                                        <td colspan="6" class="aa-cart-view-bottom">
                                            <?php
                                            if ($total) {
                                            ?>
                                              <a href="/buy"><input class="aa-cart-view-btn green-button" type="submit" value="Оформить заказ"></a>
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