<?php
include 'header.php';
?>

<!-- Start slider -->
  <section id="aa-slider">
    <div class="aa-slider-area">
      <div id="sequence" class="seq">
        <div class="seq-screen">
          <ul class="seq-canvas">
            <?php
            $bannersdir='images/banners';
            $dir = new DirectoryIterator($bannersdir);
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot()) {
                ?>  
                <li>
                    <div class="seq-model">
                        <img data-seq src="<?php echo '/'.$bannersdir.'/'.$fileinfo->getFilename() ?>" alt="Men slide img" />
                    </div>
                    <!--div class="seq-title">
                    <span data-seq>Save Up to 75% Off</span>                
                        <h2 data-seq>Men Collection</h2>                
                        <p data-seq>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, illum.</p>
                        <a data-seq href="#" class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
                    </div-->
                </li>
                <?php
                }        
            }
            ?>
          </ul>
        </div>
        <!-- slider navigation btn -->
        <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
          <a type="button" class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
          <a type="button" class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
        </fieldset>
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
                                    foreach($this->registry['goods'] as $id=>$good) {
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
  
