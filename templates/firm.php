<?php
include 'header.php';
?>

<section id="aa-subscribe">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-subscribe-area">
                    <h3><?php 
                    if ($showFirm) 
                        echo $showFirm->name; 
                    else
                        echo 'Наши бренды';
                    ?></h3>
                    <p><?php if ($showFirm)
                        echo $showFirm->description;
                    else 
                        echo 'Мы торгуем только товарами проверенных годами фирм';
                    ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <?php
                            if ($showFirm) {
                            ?>
                            <ul class="nav nav-tabs aa-products-tab">
                                <?php 
                                $i=1;
                                foreach($showFirm->categories as $catId=>$catName) {
                                    ?>
                                <li <?php if ($i==1) echo 'class="active"' ?>><a href="#cat<?php echo $catId ?>" data-toggle="tab"><?php echo $catName ?></a></li>
                                    <?php
                                    $i++;
                                }?>
                            </ul>
                            <div class="tab-content">
                                <?php 
                                $i=0;
                                foreach($showFirm->categories as $catId=>$catName) {
                                    $i++
                                ?>
                                <!-- Category -->
                                <div class="tab-pane fade <?php if ($i==1) echo 'in active' ?>" id="cat<?php echo $catId ?>">
                                    <?php
                                    include 'sort.php';
                                    ?>
                                    <ul class="aa-product-catg">
                                    <?php
                                    foreach($showFirm->goods as $good) {
                                        if (in_array($catId, $good->cats)) {
                                            $good->showInCatalog();
                                        }
                                    }
                                    ?>
                                    </ul>
                                </div>
                                <!-- /Category -->
                                <?php
                                }
                                ?>
                            </div>  
                            <?php
                            include 'modalgood.php';
                            } else {
                            ?>
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
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</section>

<?php
include 'footer.php';


