<?php
include 'header.php';

$bannersdir='images/banners';

$banners = new FilesystemIterator($bannersdir);
if ($banners->valid()) {
?>

<!-- Start slider -->
<section id="aa-slider" class="hidden-xs hidden-sm">
    <div class="aa-slider-area">
        <div id="sequence" class="seq">
            <div class="seq-screen">
                <ul <?php if (iterator_count($banners) >1) echo 'class="seq-canvas"' ?>>
                    <?php
                    $dir = new DirectoryIterator($bannersdir);
                    $ind = 1;
                    foreach ($dir as $fileinfo) {
                        if (!$fileinfo->isDot()) {
                            $newsId = filter_var($fileinfo->getFilename(), FILTER_SANITIZE_NUMBER_INT); 
                            $newsItem = $this->registry['model']->getNewsItem($newsId);
                        ?>  
                            <li <?php if ($ind == 1) echo 'class="seq-in"' ?>>
                                <div class="seq-model">
                                    <?php
                                    if ($newsItem->bannerlink)
                                        echo '<a href="' . $newsItem->bannerlink . '">';
                                    ?>
                                    <img data-seq src="<?php echo '/'.$bannersdir.'/'.$fileinfo->getFilename() ?>" alt="<?php $fileinfo->getFilename() ?>" />
                                    <?php
                                    if ($newsItem->bannerlink)
                                        echo "</a>";    
                                    ?>
                                </div>
                            </li>
                        <?php
                        $ind++;
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
                <h1 class="center">Популярные товары</h1>
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
                                        <ul class="aa-product-catg">
                                        <?php
                                        foreach($pgoods[$typeId] as $good) {
                                            $good->showInCatalog();
                                        }
                                        ?>
                                        </ul>
                                        <a class="aa-browse-btn green-button" href="/catalog/type?id=<?php echo $typeId ?>">Больше товаров <?php echo mb_strtolower($typeName) ?><span class="fa fa-long-arrow-right"></span></a>

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
                <h1 class="center">Наши бренды</h1>
                <div class="aa-client-brand-area">
                    <ul class="aa-client-brand-slider">
                        <?php 
                        foreach ($firms as $id=>$firm) {
                        ?>
                            <li><a href="/catalog/firm/<?php echo $firm->url; ?>"><img src="/images/firms/firm<?php echo $id; ?>.png" alt="<?php echo $firm->name; ?>"></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!$user->spam) {
    include 'subscribe.php';
} ?>
  
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
                            <P>Где бы вы ни были в Самарской области, мы сможем доставить товар.</P>
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

<script src="js/sequence.js"></script>
<script src="js/sequence-theme.modern-slide-in.js"></script>  

<?php
include 'footer.php';
?>
<script src="/js/subscribe.js"></script>
