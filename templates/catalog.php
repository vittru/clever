<?php
include 'header.php';
$showGoods = sizeof($catalogGoods);
function cmp($a, $b)
{
    return strcmp($b->isAvailable(), $a->isAvailable());
}

usort($catalogGoods, "cmp");
?>

<section class="aa-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                include 'breadcrumbs.php';
                ?>
                <h1 class="center"><?php echo $pageHeader ?></h1>
                <p><?php echo $pageSubHeader ?></p>
                <h4 class="center"><?php 
                    if (!$showGoods) {
                        echo 'Сейчас у нас нет таких товаров';
                    } else {
                        echo $pageSecondHeader;
                    }
                    ?>
                </h4>
            </div>
        </div>    
    </div>
</section>
<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                if ($showGoods) {
                ?>
                <div class="col-md-9 col-md-push-3 col-xs-12">
                    <?php
                    include 'sort.php';
                    ?>                                
                    <ul class="aa-product-catg">
                        <?php
                        foreach($catalogGoods as $goodId=>$good) {
                            $good->showInCatalog($bestBefore);
                        }
                        ?>
                    </ul>
                    <div id="empty-catg" class="aa-empty-catg" hidden>Мы не нашли товаров, удовлетворяющих вашему запросу</div>
                </div>
                <?php
                include 'filter.php';
                } 
                ?>
            </div>    
        </div>
    </div>
</section>
<?php
if ($descAfter) {
?>
<section class="aa-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                echo $descAfter;
                ?>
            </div>
        </div>    
    </div>  
</section>    
<?php
}
include 'footer.php';