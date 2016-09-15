<?php
include 'header.php';

$bannersdir='images/banners';


if ((new \FilesystemIterator($bannersdir))->valid()) {
?>

<!-- Start slider -->
<section id="aa-slider">
    <div class="aa-slider-area">
        <div id="sequence" class="seq">
            <div class="seq-screen">
                <ul class="seq-canvas">
                    <?php
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
<?php
}
?>
  

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
                                    <li <?php if ($i==1) echo 'class="active"' ?>>
                                        <a href="#type<?php echo $typeId ?>" data-toggle="tab"><?php echo $typeName ?></a>
                                    </li>
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
                                        <?php
                                        //include 'sort.php';
                                        ?>
                                        <ul class="aa-product-catg">
                                        <?php
                                        $count = 0;
                                        foreach($this->registry['goods'] as $id=>$good) {
                                            if ($count < 8 and in_array($typeName, $good->types) and $good->isAvailable()) {
                                                $count++;
                                                $good->showInCatalog();
                                            }
                                        }
                                        ?>
                                        </ul>
                                        <a class="aa-browse-btn" href="/catalog/type?id=<?php echo $typeId ?>">Больше товаров <?php echo mb_strtolower($typeName) ?><span class="fa fa-long-arrow-right"></span></a>

                                    </div>
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

  <!-- Client Brand -->
<section id="aa-client-brand">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-client-brand-area">
                    <ul class="aa-client-brand-slider">
                        <?php 
                        foreach ($firms as $id=>$name) {
                        ?>
                            <li><a href="/catalog/firm?id=<?php echo $id; ?>"><img src="/images/firms/firm<?php echo $id; ?>.png" alt="<?php echo $name; ?>"></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!$user->spam) {?>
<!-- Subscribe section -->
<section id="aa-subscribe">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-subscribe-area">
                    <h3>Подпишитесь на нашу рассылку </h3>
                    <p>Это позволит Вам первыми узнавать обо всех наших акциях и новинках!</p>
                    <form action="" class="aa-subscribe-form" id="subscribe-form" novalidate>
                        <input type="email" name="" id="subscribe-email" placeholder="Ваша почта" value="<?php echo $user->email;?>">
                        <input type="submit" value="ОК">
                    </form>
                    <div id="subscribe-error" display="none"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / Subscribe section -->
<?php } ?>
  
<section id="aa-support">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-support-area">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="aa-support-single">
                            <span class="fa fa-leaf"></span>
                            <h4>Качество</h4>
                            <P>Всегда свежая косметика от производителя.</P>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="aa-support-single">
                            <span class="fa fa-truck"></span>
                            <h4>Доставка</h4>
                            <P>Где бы вы ни были в Самарской области, мы сможем доставить вам наш товар.</P>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="aa-support-single">
                            <span class="fa fa-rub"></span>
                            <h4>Возврат</h4>
                            <P>Если что-то пошло не так, мы готовы обменять товар обратно на деньги.</P>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
include 'footer.php';
  
