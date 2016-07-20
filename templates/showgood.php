<?php
$good = $this->registry['good'];
$hasEffects = $good->hasEffects();
$hasSkintypes = $good->hasSkintypes();
$hasHairtypes = $good->hasHairtypes();
$canBeBought = true;

?>
<html>  
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 class="modal-title"><?php echo $good->name ?></h3>
    <div hidden="" id="pId"><?php echo $good->id ?></div>
</div>  
<div class="modal-body">
<div class="row">
  <!-- Modal view slider -->
  <div class="col-md-4 col-sm-4 col-xs-12">                              
    <div class="aa-product-view-slider">                                
      <div class="simpleLens-gallery-container" id="demo-1">
        <div class="simpleLens-container">
            <div class="simpleLens-big-image-container">
                <a class="simpleLens-lens-image">
                    <img src="<?php echo $good->getImage() ?>" class="simpleLens-big-image">
                </a>
            </div>
        </div>
        <!--div class="simpleLens-thumbnails-container">
            <a href="#" class="simpleLens-thumbnail-wrapper"
               data-lens-image="img/view-slider/large/polo-shirt-1.png"
               data-big-image="img/view-slider/medium/polo-shirt-1.png">
                <img src="img/view-slider/thumbnail/polo-shirt-1.png">
            </a>                                    
            <a href="#" class="simpleLens-thumbnail-wrapper"
               data-lens-image="img/view-slider/large/polo-shirt-3.png"
               data-big-image="img/view-slider/medium/polo-shirt-3.png">
                <img src="img/view-slider/thumbnail/polo-shirt-3.png">
            </a>

            <a href="#" class="simpleLens-thumbnail-wrapper"
               data-lens-image="img/view-slider/large/polo-shirt-4.png"
               data-big-image="img/view-slider/medium/polo-shirt-4.png">
                <img src="img/view-slider/thumbnail/polo-shirt-4.png">
            </a>
        </div-->
      </div>
    </div>
  </div>
  <!-- Modal view content -->
  <div class="col-md-8 col-sm-8 col-xs-12">
    <div class="aa-product-view-content">

      <div class="aa-price-block">
            <?php
            if (sizeof($good->sizes) > 0) 
                foreach($good->sizes as $sizeId=>$size) { 
                ?>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <?php echo $size->code; ?>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <?php echo $size->size; ?>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <?php echo $size->getWebPrice($good->sale); ?>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <select class="form-control quantity" id="sel<?php echo $sizeId; ?>" <?php if (!$size->isAvailable()) echo 'disabled' ?> onchange="modifyBasket()">
                                <option>0</option>
                                <option <?php if (sizeof($good->sizes)==1 and $size->isAvailable()) echo 'selected' ?>>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <p class="aa-product-avilability">
                            <?php if ($size->isAvailable()) 
                                echo 'В наличии';
                                else
                                    echo 'Нет на складе'; ?>
                            </p>    
                        </div>
                    </div>    
                <?php
                }
            else {
                $canBeBought = false;
                ?>
                <p>К сожалению данного товара нет в наличии</p>
                <?php
            }
                ?>
        <!--span class="aa-product-view-price"><?php //echo $good->getPrice() ?></span>
        <!--p class="aa-product-avilability">Avilability: <span>In stock</span></p-->
      </div>
      <p>Производитель: <?php echo $this->registry['firms'][$good->firmId] ?></p>  
      <p><?php echo $good->shortdesc ?></p>
      <!--h4>Size</h4>
      <div class="aa-prod-view-size">
        <a href="#">S</a>
        <a href="#">M</a>
        <a href="#">L</a>
        <a href="#">XL</a>
      </div-->
      <!--div class="aa-prod-quantity">
        <form action="">
          <select name="" id="">
            <option value="0" selected="1">1</option>
            <option value="1">2</option>
            <option value="2">3</option>
            <option value="3">4</option>
            <option value="4">5</option>
            <option value="5">6</option>
          </select>
        </form>
        <!--p class="aa-prod-category">
          Category: <a href="#">Polo T-Shirt</a>
        </p-->
      </div>
      <div class="aa-prod-view-bottom">
        <a href="#" class="aa-add-to-cart-btn" data-dismiss="modal" <?php if (!$canBeBought) echo 'disabled' ?>><span class="fa fa-shopping-cart"></span>В корзину</a>
        <!--a href="#" class="aa-add-to-cart-btn">View Details</a-->
      </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#description" data-toggle="tab">Описание</a></li>
            <li><a href="#madeOf" data-toggle="tab">Состав</a></li>
            <li><a href="#howTo" data-toggle="tab">Способ применения</a></li>
            <li><a href="#problems" data-toggle="tab">Проблемы</a></li>
            <?php if ($hasEffects) { ?>
            <li><a href="#effects" data-toggle="tab">Эффекты</a></li>
            <?php }?>
            <?php if ($hasSkintypes) { ?>
            <li><a href="#skintypes" data-toggle="tab">Типы кожи</a></li>
            <?php }?>
            <?php if ($hasHairtypes) { ?>
            <li><a href="#hairtypes" data-toggle="tab">Типы волос</a></li>
            <?php }?>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active aa-product-info-tab" id="description"><?php echo $good->getWebDescription(); ?></div>
            <div class="tab-pane fade aa-product-info-tab" id="madeOf"><?php echo $good->getWebMadeOf(); ?></div>
            <div class="tab-pane fade aa-product-info-tab" id="howTo"><?php echo $good->getWebHowTo(); ?></div>
            <div class="tab-pane fade aa-product-info-tab" id="problems"><?php echo $good->problem; ?></div>
            <?php if ($hasEffects) { ?>
            <div class="tab-pane fade" id="effects">
                <ul class="list-group">
                <?php foreach($good->effs as $eff) { ?>
                    <li class="list-group-item"><?php echo $this->registry['effects'][$eff] ?></li>
                <?php } ?>
                </ul>
            </div>
            <?php }?>
            <?php if ($hasSkintypes) { ?>
            <div class="tab-pane fade" id="skintypes">
                <ul class="list-group">
                <?php foreach($good->skintypes as $st) { ?>
                    <li class="list-group-item"><?php echo $this->registry['skintypes'][$st] ?></li>
                <?php } ?>
                </ul>
            </div>
            <?php }?>
            <?php if ($hasHairtypes) { ?>
            <div class="tab-pane fade" id="hairtypes">
                <ul class="list-group">
                <?php foreach($good->hairtypes as $ht) { ?>
                    <li class="list-group-item"><?php echo $this->registry['hairtypes'][$ht] ?></li>
                <?php } ?>
                </ul>
            </div>
            <?php }?>
        </div>    
    </div>
  </div>
</div>

<script src="/js/modalgood.js"></script>       
    
</html><!-- / quick view modal -->  
