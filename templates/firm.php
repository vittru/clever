<?php
include 'header.php';
?>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="aa-product-header">
                <h1><?php 
                if ($showFirm)
                    echo $showFirm->name; 
                else 
                    echo 'Наши бренды';
                ?></h1>
                <p><?php
                if ($showFirm)
                    echo $showFirm->description;
                else
                    echo 'Мы торгуем только товарами проверенных годами брендов';
                ?></p>
            </div>

            <?php 
            if ($showFirm) {
            ?>
            <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                <div class="aa-product-catg-content">
                    <div class="aa-product-area">
                        <div class="aa-product-catg-body">
                            <ul class="aa-product-catg">
                                <?php
                                foreach($showFirm->goods as $good) {
                                    //if (in_array($catId, $good->cats)) {
                                        $good->showInCatalog();
                                    //}
                                }
                                ?>
                            </ul>
                        </div>
                    </div>  
                    <?php
                    include 'modalgood.php';
                    ?>
                </div>
            </div>
            <?php
                include 'filter.php';
            } else {
            ?>
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <ul class="aa-product-catg">
                                <?php
                                foreach($firms as $id=>$firm) {
                                ?>    
                                <li class="col-sm-3 good">
                                    <figure>
                                        <a class="aa-product-img" href="/catalog/firm/<?php echo $firm->url ?>"><img src="/images/firms/firm<?php echo $id ?>.png" alt="<?php echo $firm->name ?>"></a>
                                        <figcaption>
                                            <h4 class="aa-product-title"><a href="/catalog/firm/<?php echo $firm->url ?>"><?php echo $firm->name ?></a></h4>
                                        </figcaption>
                                    </figure>                         
                                </li> 
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php    
            }
            ?>
        </div>
    </div>
</section>

<?php
include 'footer.php';


