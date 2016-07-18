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
                                    ?>
                                        <li class="col-sm-3">
                                          <figure>
                                            <a class="aa-product-img" data-placement="top" data-toggle="modal" data-target="#quick-view-modal" href="/showgood?id=<?php echo $good->id ?>"><img src="<?php
                                            $file_name = 'images/goods/good' . $good->id . '-1.jpg';
                                            if (!file_exists($file_name)) {
                                                $file_name = 'images/goods/good0.png';
                                            }    
                                            echo '/'.$file_name;
                                            ?>" alt="<?php echo $good->name ?>"></a>
                                            <a class="aa-add-card-btn" href="#"><span class="fa fa-shopping-cart"></span>В корзину</a>
                                            <figcaption>
                                                <h4 class="aa-product-title"><a href="/showgood?id=<?php echo $good->id ?>" data-toggle2="tooltip" data-placement="top" data-toggle="modal" data-target="#quick-view-modal"><?php echo $good->name ?></a></h4>
                                                <span class="aa-product-price"><?php echo $good->getPrice() ?> руб.</span>
                                                <?php 
                                                if ($good->sale > 0) {
                                                ?>
                                                <span class="aa-product-price"><del><?php echo $good->getOldPrice() ?> руб.</del></span>
                                                <?php    
                                                }
                                                ?>
                                            </figcaption>
                                          </figure>                        
                                          <!-- div class="aa-product-hvr-content">
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
                                            <a href="#" data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>                          
                                          </div -->
                                          <?php 
                                          if ($good->sale > 0) {
                                          ?>
                                              <span class="aa-badge aa-sale">Скидка!</span> 
                                          <?php    
                                          }        
                                          if (!$good->isAvailable()) {
                                          ?>
                                              <span class="aa-badge aa-sold-out">Нет в наличии</span>
                                          <?php    
                                          }
                                          ?> 
                                        </li>
                                    <?php    
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
                  <!-- quick view modal -->                  
                  <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">  
                          <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              
                          </div>  
                        <div class="modal-body">
                        </div>                        
                      </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                  </div><!-- / quick view modal -->              

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
  
