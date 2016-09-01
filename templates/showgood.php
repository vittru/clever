<?php
$good = $this->registry['good'];
$hasEffects = $good->hasEffects();
$hasSkintypes = $good->hasSkintypes();
$hasHairtypes = $good->hasHairtypes();
$canBeBought = true;

?>
<html>
    <link href="/css/lightbox.css" rel="stylesheet">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 class="modal-title"><?php echo $good->name ?></h3>
    <div hidden="" id="pId"><?php echo $good->id ?></div>
</div>  
<div class="modal-body">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">  
            <?php
            $firstImage = $good->getImage();
            $secondImage = $good->getSecondImage();
            $thirdImage = $good->getThirdImage();
            $colsm = 12;
            if ($thirdImage)
                $colsm = 4;
            else if ($secondImage)
                $colsm = 6;
            ?>
            <a href="<?php echo $firstImage; ?>" data-lightbox="lightbox" data-title='<?php echo $good->name ?>' class="col-sm-<?php echo $colsm ?>">
                <img src="<?php echo $firstImage; ?>" class="img-responsive">
            </a>    
            <?php 
            if ($secondImage) {
            ?>
            <a href="<?php echo $secondImage ?>" data-lightbox="lightbox" data-title='<?php echo $good->name ?>'  class="col-sm-<?php echo $colsm ?>">
                <img src="<?php echo $secondImage ?>" class="img-responsive">
            </a>    
            <?php
            }
            if ($thirdImage) {
            ?>
            <a href="<?php echo $thirdImage ?>" data-lightbox="lightbox" data-title='<?php echo $good->name ?>' class="col-sm-<?php echo $colsm ?>">
                <img src="<?php echo $thirdImage ?>" class="img-responsive">
            </a>    
            <?php 
            }
            ?>
        </div>
  <!-- Modal view content -->
  <div class="col-md-8 col-sm-8 col-xs-12">
    <div class="aa-product-view-content">

      <div class="aa-price-block">
            <?php
            if (sizeof($good->sizes) > 0) { 
                ?>
                <table class="table">
                    <th>Артикул</th>
                    <th>Объем</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Наличие</th>
                <?php
                foreach($good->sizes as $sizeId=>$size) { 
                ?>
                    <tr>
                        <td>
                            <?php echo $size->code; ?>
                        </td>
                        <td>
                            <?php echo $size->size; ?>
                        </td>
                        <td>
                            <?php echo $size->getWebPrice($good->sale); ?>
                        </td>
                        <td>
                            <select class="form-control quantity" id="sel<?php echo $sizeId; ?>" <?php if (!$size->isAvailable()) echo 'disabled' ?> onchange="modifyBasket()">
                                <option>0</option>
                                <option <?php if (sizeof($good->sizes)==1 and $size->isAvailable()) echo 'selected' ?>>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </td>
                        <td>
                            <!--p class="aa-product-avilability"-->
                            <?php if ($size->isAvailable()) 
                                echo '<span class="available">В наличии</span>';
                                else
                                    echo '<span class="unavailable">Нет на складе</span>'; ?>
                            <!--/p-->    
                        </td>
                    </tr> 
                <?php
                }
            ?>
                </table>
            <?php
            }    
            else {
                $canBeBought = false;
                ?>
                <p>К сожалению данного товара нет в наличии</p>
                <?php
            }
                ?>
      </div>
      <p>Производитель: <?php echo $this->registry['firms'][$good->firmId] ?></p>  
      <p><?php echo $good->shortdesc ?></p>
      </div>
      <div class="aa-prod-view-bottom">
        <a class="aa-add-to-cart-btn" data-dismiss="modal" <?php if (!$canBeBought) echo 'disabled' ?>><span class="fa fa-shopping-cart"></span>В корзину</a>
        <!--a href="#" class="aa-add-to-cart-btn">View Details</a-->
      </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#description" data-toggle="tab">Описание</a></li>
            <li><a href="#madeOf" data-toggle="tab">Состав</a></li>
            <li><a href="#howTo" data-toggle="tab">Способ применения</a></li>
            <!--li><a href="#bestbefore" data-toggle="tab">Срок хранения</a></li>
            <li><a href="#precaution" data-toggle="tab">Противопоказания</a></li-->
            <li><a href="#problems" data-toggle="tab">Проблемы</a></li>
            <?php if ($hasEffects) { ?>
            <li><a href="#effects" data-toggle="tab">Эффекты</a></li>
            <?php }?>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active aa-product-info-tab" id="description">
                <?php if ($hasSkintypes) {
                    echo '<p><b>Типы кожи: </b>'; 
                    $toEnd = count($good->skintypes);
                    foreach($good->skintypes as $st) { 
                        echo mb_strtolower($this->registry['skintypes'][$st]);
                        if (0 !== --$toEnd) echo ", ";
                    } 
                    echo '</p>';
                }?>
                <?php if ($hasHairtypes) {
                    echo '<p><b>Типы волос: </b>'; 
                    $toEnd = count($good->hairtypes);
                    foreach($good->hairtypes as $ht) { 
                        echo mb_strtolower($this->registry['hairtypes'][$ht]); 
                        if (0 !== --$toEnd) echo ", ";
                    } 
                    echo '</p>';
                }?>
                <?php echo $good->getWebDescription(); ?>
                <?php echo $good->getWebBestbefore(); ?>
                <?php echo $good->getWebPrecaution(); ?>
            </div>
            <div class="tab-pane fade aa-product-info-tab" id="madeOf"><?php echo $good->getWebMadeOf(); ?></div>
            <div class="tab-pane fade aa-product-info-tab" id="howTo"><?php echo $good->getWebHowTo(); ?></div>
            <div class="tab-pane fade" id="problems">
                <ul class="list-group">
                <?php foreach($good->problems as $problem) { ?>
                    <li class="list-group-item"><?php echo $this->registry['problems'][$problem] ?></li>
                <?php } ?>
                </ul>            
            </div>
            <?php if ($hasEffects) { ?>
            <div class="tab-pane fade" id="effects">
                <ul class="list-group">
                <?php foreach($good->effs as $eff) { ?>
                    <li class="list-group-item"><?php echo $this->registry['effects'][$eff] ?></li>
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
