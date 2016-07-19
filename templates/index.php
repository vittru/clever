<?php
include 'header.php';
?>

<!-- banner section -->
<section id="aa-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">        
                <div class="row">
                    <div class="aa-banner-area">
                        <a href="#"><img src="/images/fashion-banner.jpg" alt="Наши акции"></a>
                    </div>
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
                        <!-- start product navigation -->
                            <ul class="nav nav-tabs aa-products-tab">
                                <?php 
                                $i=1;
                                foreach($this->registry['types'] as $typeId=>$typeName) {
                                    ?>
                                <li <?php if ($i==1) echo 'class="active"' ?>><a href="#type<?php echo $typeId ?>" data-toggle="tab"><?php echo $typeName ?></a></li>
                                    <?php
                                    $i++;
                                }?>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <?php 
                                $i=0;
                                foreach($this->registry['types'] as $typeId=>$typeName) {
                                    $i++
                                ?>
                                <!-- Category -->
                                <div class="tab-pane fade <?php if ($i==1) echo 'in active' ?>" id="type<?php echo $typeId ?>">
                                    <ul class="aa-product-catg">
                                    <?php
                                    foreach($this->registry['goods'] as $good) {
                                        if (in_array($typeName, $good->types) ) {
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
?>
  
