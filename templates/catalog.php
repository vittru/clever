<?php
include 'header.php';
$showGoods = sizeof($catalogGoods);
?>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-header">
                    <h1><?php echo $pageHeader ?></h1>
                    <p><?php echo $pageSubHeader ?></p>
                    <h4><?php 
                        if (!$showGoods)
                            echo 'Сейчас у нас нет таких товаров';
                        else
                            echo $pageSecondHeader;
                    ?></h4>
                    </div>
                </div>
                <div class="row">
                    <?php
                    if ($showGoods) {
                    ?>
                    <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                        <div class="aa-product-catg-content">
                            <div class="aa-product-area">
                                <?php
                                include 'sort.php';
                                ?>                                
                                <div class="aa-product-catg-body">
                                    <ul class="aa-product-catg">
                                        <?php
                                        foreach($catalogGoods as $goodId=>$good) {
                                            $good->showInCatalog($bestBefore);
                                        }
                                        ?>
                                    </ul>
                                    <div id="empty-catg" class="aa-empty-catg" hidden>Мы не нашли товаров, удовлетворяющих вашему запросу</div>
                                </div>
                            </div>  
                            <?php
                            include 'modalgood.php';
                            ?>
                        </div>
                    </div>
                <?php
                    //$hideFilterCat = true;
                    include 'filter.php';
                } 
                ?>
                </div>
            </div>    
        </div>
    </div>
</section>

<?php
include 'footer.php';
