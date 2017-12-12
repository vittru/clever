<?php
    $canBeBought = false;

    if (!$pm) {
        include 'header.php';
    } else {
?>
<html>
<?php
    }
?>
    <link href="/css/lightbox.css" rel="stylesheet">
    <?php
    if ($pm) {
    ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <?php
    } else {
    ?>  
        <section id="single-product">
        <div class="container">
        <?php        
        if (sizeof($breadcrumbs)) {
        ?>
            <div class="row">
                <ul class="breadcrumb">
                    <?php
                    foreach ($breadcrumbs as $name=>$url) {
                        echo '<li>';
                        if ($url) {
                            echo '<a href="'. $url . '">';
                        }
                        echo $name;
                        if ($url) {
                            echo '</a>';
                        }
                        echo '</li>';
                    }
                    ?>
                </ul>    
            </div>
        <?php    
        }
    }
    ?>
        <h1 class="modal-title"><?php echo $showGood->name ?></h1>
        <div hidden="" id="pId"><?php echo $showGood->id ?></div>
    <?php
    if ($pm) {
    ?>    
    </div>  
    <div class="modal-body">
    <?php
    } 
    ?>
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">  
                <?php
                $firstImage = $showGood->getImage();
                $secondImage = $showGood->getSecondImage();
                $thirdImage = $showGood->getThirdImage();
                $colsm = 12;
                if ($thirdImage)
                    $colsm = 4;
                else if ($secondImage)
                    $colsm = 6;
                ?>
                <a href="<?php echo $firstImage; ?>" data-lightbox="lightbox" data-title='<?php echo $showGood->name ?>' class="col-sm-<?php echo $colsm ?>">
                    <img src="<?php echo $firstImage; ?>" class="img-responsive image-good">
                </a>    
                <?php 
                if ($secondImage) {
                ?>
                <a href="<?php echo $secondImage ?>" data-lightbox="lightbox" data-title='<?php echo $showGood->name ?>'  class="col-sm-<?php echo $colsm ?>">
                    <img src="<?php echo $secondImage ?>" class="img-responsive image-good">
                </a>    
                <?php
                }
                if ($thirdImage) {
                ?>
                <a href="<?php echo $thirdImage ?>" data-lightbox="lightbox" data-title='<?php echo $showGood->name ?>' class="col-sm-<?php echo $colsm ?>">
                    <img src="<?php echo $thirdImage ?>" class="img-responsive image-good">
                </a>    
                <?php 
                }
                ?>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="aa-product-view-content">
                    <div class="short-desc"><?php echo $showGood->shortdesc ?></div>
                    <?php
                    $firm = $this->registry['firms'][$showGood->firmId];
                    if ($firm) {
                    ?>
                        <div class="firm"><b>Бренд:</b> <a href="/catalog/firm/<?php echo $firm->url; ?>"><?php echo $firm->name ?></a></div>  
                    <?php
                    }
                    if ($showGood->hasBB()) {
                    ?>
                    <ul class="nav nav-tabs price-tabs">
                        <li <?php if (!$bb) echo 'class="active"'?>><a href="#main" data-toggle="tab">Основной товар</a></li>
                        <li <?php if ($bb) echo 'class="active"'?>><a href="#bb" data-toggle="tab">Скидки</a>
                    </ul>
                    <?php
                    }
                    ?>
                    <div class="tab-content">
                        <div class="tab-pane fade in <?php if (!$bb) echo 'active'?>" id="main">
                            <div class="aa-price-block">
                                <?php
                                if (sizeof($showGood->sizes) > 0) { 
                                ?>
                                <table class="table">
                                    <th class="hidden-xs">Артикул</th>
                                    <th>Размер</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <?php
                                    foreach($showGood->sizes as $sizeId=>$size) { 
                                    ?>
                                    <tr>
                                        <td class="hidden-xs"><?php echo $size->code; ?></td>
                                        <td><?php echo $size->size; ?></td>
                                        <td><?php echo $size->getWebPrice($showGood->sale); ?></td>
                                        <td>
                                            <?php
                                            if ($size->isAvailable()) {
                                            ?>
                                                <input class="quantity form-control" data-price="<?php echo $size->getPrice($showGood->sale); ?>" data-sale="<?php if ($showGood->sale) echo "1"; else echo "0"; ?>" type="number" id="sel<?php echo $sizeId; ?>" value="<?php if (sizeof($showGood->sizes) == 1) { echo '1'; if (!$bb) $canBeBought = true;} else echo '0';  ?>" onchange="modifyBasket()">
                                            <?php
                                            } else
                                                echo '<span class="unavailable">Нет на складе</span>'
                                            ?>
                                        </td>
                                    </tr> 
                                    <?php
                                    }
                                    ?>
                                    <tr><td colspan="4"></td></tr>
                                </table>
                                <?php
                                }    
                                else {
                                ?>
                                <p>К сожалению данного товара нет в наличии</p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if ($showGood->hasBB()) {
                        ?>
                        <div class="tab-pane fade in <?php if ($bb) echo 'active'?>" id="bb">
                            <div class="aa-price-block">
                                <?php
                                if (sizeof($showGood->sizes) > 0) { 
                                ?>
                                <table class="table">
                                    <th class="hidden-xs">Артикул</th>
                                    <th>Размер</th>
                                    <th>Срок годности</th>
                                    <th>Цена</th>
                                    <th>Количество</th>
                                    <?php
                                    foreach($showGood->sizes as $sizeId=>$size) 
                                        if ($size->isBB()){ 
                                    ?>
                                    <tr>
                                        <td class="hidden-xs"><?php echo $size->code;?></td>
                                        <td><?php echo $size->size; ?></td>
                                        <td class="orange"><?php echo strftime('%e/%m/%G', strtotime($size->bestbefore)); ?></td>
                                        <td><?php echo $size->getWebBBPrice($showGood->sale); ?></td>
                                        <td>
                                            <?php
                                            //if ($size->isAvailable()) {
                                            ?>
                                                <input class="quantity form-control" data-price="<?php echo $size->bbprice; ?>" data-sale="1" type="number" id="sel<?php echo $sizeId; ?>" value="<?php if (sizeof($showGood->sizes)==1) {echo '1'; if ($bb) $canBeBought = true;} else echo '0';  ?>" onchange="modifyBasket()">
                                            <?php
                                            //} else
                                            //    echo '<span class="unavailable">Нет на складе</span>'
                                            ?>
                                        </td>
                                    </tr> 
                                    <?php
                                    }
                                    ?>
                                    <tr><td colspan="5"></td></tr>
                                </table>
                                <?php
                                }    
                                else {
                                ?>
                                <p>К сожалению данного товара нет в наличии</p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="aa-prod-view-bottom">
                    <a class="green-button" id="emailMeBtn" <?php if ($bb or $showGood->isAvailable() ) echo 'style="display:none;" ' ?>><span class="fa fa-envelope" data-toggle="modal" data-target="#emailMe"></span>Сообщить о наличии</a>
                    <a class="aa-add-to-cart-btn green-button" <?php if (!$canBeBought) echo 'disabled '; if (!$bb and !$showGood->isAvailable()) echo 'style="display:none;" ' ?> title="Товар добавлен в корзину" data-content="Оформить заказ"><span class="fa fa-shopping-cart"></span>В корзину</a>
                    <?php
                    if ($isadmin) {
                    ?>
                        <a class="green-button" href="/editgood?good=<?php echo $showGood->id ?>">Редактировать</a>
                    <?php
                    }    
                    ?>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#description" data-toggle="tab">Описание</a></li>
                    <?php
                    if ($showGood->madeOf) {
                    ?>
                    <li><a href="#madeOf" data-toggle="tab">Состав</a></li>
                    <?php }
                    if ($showGood->howTo) {
                    ?>
                    <li><a href="#howTo" data-toggle="tab">Способ применения</a></li>
                    <?php
                    }
                    if ($hasProblems or $hasEffects) {
                    ?>
                        <li><a href="#effect" data-toggle="tab">Эффект</a></li>
                    <?php } ?>    
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active aa-product-info-tab" id="description">
                        <?php if ($hasSkintypes) {
                            echo '<p><b>Типы кожи: </b>'; 
                            $toEnd = count($showGood->skintypes);
                            foreach($showGood->skintypes as $st) { 
                                echo mb_strtolower($this->registry['skintypes'][$st]);
                                if (0 !== --$toEnd) echo ", ";
                            } 
                            echo '</p>';
                        }?>
                        <?php if ($hasHairtypes) {
                            echo '<p><b>Типы волос: </b>'; 
                            $toEnd = count($showGood->hairtypes);
                            foreach($showGood->hairtypes as $ht) { 
                                echo mb_strtolower($this->registry['hairtypes'][$ht]); 
                                if (0 !== --$toEnd) echo ", ";
                            } 
                            echo '</p>';
                        }?>
                        <?php echo $showGood->getWebDescription(); ?>
                        <?php echo $showGood->getWebBestbefore(); ?>
                        <?php echo $showGood->getWebPrecaution(); ?>
                    </div>
                    <?php
                    if ($showGood->madeOf) {
                    ?>
                        <div class="tab-pane fade aa-product-info-tab" id="madeOf"><?php echo $this->registry['model']->insertVoc($showGood->getWebMadeOf()); ?></div>
                    <?php 
                    } 
                    if ($showGood->howTo) {
                    ?>
                    <div class="tab-pane fade aa-product-info-tab" id="howTo"><?php echo $showGood->getWebHowTo(); ?></div>
                    <?php
                    }
                    if ($hasProblems or $hasEffects) {
                    ?>
                    <div class="tab-pane fade aa-product-info-tab" id="effect">
                        <?php if ($hasProblems) { ?>
                            <p><b>Эффективен при следующих проблемах:</b></p>
                            <ul>
                            <?php foreach($showGood->problems as $problem) { ?>
                                <li><?php echo $this->registry['problems'][$problem] ?></li>
                            <?php } ?>
                            </ul>            
                        <?php } ?>
                        <?php if ($hasEffects) { ?>
                            <p><b>Эффект:</b></p>
                            <ul>
                            <?php foreach($showGood->effs as $eff) { ?>
                                <li><?php echo $this->registry['effects'][$eff] ?></li>
                            <?php } ?>
                            </ul>
                        <?php }?>
                    </div>
                    <?php } ?>
                </div>    
            </div>
        </div>
    </div>
    <?php
    if (!$pm) {
    ?>
        </section>
    <?php
    }

    
    if (!$pm) {
        include 'footer.php';
    } else {
    ?>
    </html>
    <?php
    }
    ?>
    <script src="/js/modalgood.js?20171114"></script> 