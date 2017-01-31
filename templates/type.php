<?php
include 'header.php';
?>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-header">
                    <h1><?php 
                    if ($type) 
                        echo 'Товары ' . mb_strtolower ($type); 
                    else
                        echo 'Экологические товары';
                    ?></h1>
                    <p><?php if (!$type)
                        echo 'Мы постарались разбить весь наш ассортимент косметики по категориям для удобства поиска';
                    ?></p>
                    </div>
                </div>
                <div class="row">
                    <?php
                    if ($type) {
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
                                        foreach($goods as $good) {
                                            $good->showInCatalog();
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
                        $hideFilterType = true;
                        include 'filter.php';
                    } else {
                    ?>
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <ul class="aa-product-catg">
                                <?php
                                foreach($types as $id=>$name) {
                                ?>    
                                <li class="col-sm-3 good">
                                  <figure>
                                    <a class="aa-product-img" href="/catalog/type?id=<?php echo $id ?>"><img src="/images/types/type<?php echo $id ?>.png" alt="<?php echo $name ?>"></a>
                                    <figcaption>
                                        <h4 class="aa-product-title"><a href="/catalog/type?id=<?php echo $id ?>"><?php echo $name ?></a></h4>
                                    </figcaption>
                                  </figure>                         
                                </li> 
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>    
        </div>
    </div>
</section>

<?php
include 'footer.php';


