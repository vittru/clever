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
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <?php
                            if ($type) {
                            ?>
                            <ul class="nav nav-tabs aa-products-tab">
                                <?php 
                                $i=1;
                                foreach($firms as $firmId=>$firmName) {
                                    ?>
                                <li <?php if ($i==1) echo 'class="active"' ?>><a href="#firm<?php echo $firmId ?>" data-toggle="tab"><?php echo $firmName ?></a></li>
                                    <?php
                                    $i++;
                                }?>
                            </ul>
                            <div class="tab-content">
                                <?php 
                                $i=0;
                                foreach($firms as $firmId=>$firmName) {
                                    $i++
                                ?>
                                <!-- Category -->
                                <div class="tab-pane fade <?php if ($i==1) echo 'in active' ?>" id="firm<?php echo $firmId ?>">
                                    <?php
                                    include 'sort.php';
                                    ?>
                                    <ul class="aa-product-catg">
                                    <?php
                                    foreach($goods as $good) {
                                        //echo $firmId . " " . $good->firmId."; ";
                                    
                                        if (in_array($type, $good->types) and $good->firmId == $firmId) {
                                            $good->showInCatalog();
                                        }
                                    }
                                    ?>
                                    </ul>
                                </div>
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


