<?php
$firmId=$_GET['id'];
if ($firmId) {
    $firm = $this->registry['model']->getFirm($firmId);
} 
include 'header.php';
?>

<section id="aa-subscribe">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-subscribe-area">
                    <h3><?php echo $firm->name ?> </h3>
                    <p><?php echo $firm->description ?></p>
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
                                foreach($firm->categories as $catId=>$catName) {
                                    ?>
                                <li <?php if ($i==1) echo 'class="active"' ?>><a href="#cat<?php echo $catId ?>" data-toggle="tab"><?php echo $catName ?></a></li>
                                    <?php
                                    $i++;
                                }?>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <?php 
                                $i=0;
                                foreach($firm->categories as $catId=>$catName) {
                                    $i++
                                ?>
                                <!-- Category -->
                                <div class="tab-pane fade <?php if ($i==1) echo 'in active' ?>" id="cat<?php echo $catId ?>">
                                    <ul class="aa-product-catg">
                                    <?php
                                    foreach($firm->goods as $good) {
                                        if (in_array($catId, $good->cats)) {
                                    ?>
                                        <li class="col-sm-3">
                                          <figure>
                                            <a class="aa-product-img" data-toggle2="tooltip" data-placement="top" data-toggle="modal" data-target="#quick-view-modal" href="/showgood?id=<?php echo $good->id ?>"><img src="/images/goods/good<?php echo $good->id ?>-1.jpg" alt="<?php echo $good->name ?>"></a>
                                            <a class="aa-add-card-btn" href="#"><span class="fa fa-shopping-cart"></span>В корзину</a>
                                            <figcaption>
                                                <h4 class="aa-product-title"><a href="#" data-toggle2="tooltip" data-placement="top" data-toggle="modal" data-target="#quick-view-modal"><?php echo $good->name ?></a></h4>
                                                <span class="aa-product-price"><?php echo $good->getPrice() ?>&#8381;</span>
                                                <?php 
                                                if ($good->sale > 0) {
                                                ?>
                                                <span class="aa-product-price"><del><?php echo $good->getOldPrice() ?>&#8381;</del></span>
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


