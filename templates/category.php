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
                    if ($showCategory) 
                        echo $showCategory->name; 
                    else
                        echo 'Категории товаров';
                    ?></h1>
                    <p><?php if ($showCategory)
                        echo $showCategory->description;
                    else 
                        echo 'Мы постоянно стараемся расширить наш ассортимент';
                    ?></p>
                    </div>
                </div>
                <div class="row">
                    <?php
                    if ($showCategory) {
                    ?>
                    <div class="col-lg-9 col-md-9 col-sm-8 col-md-push-3">
                        <div class="aa-product-catg-content">
                            <div class="aa-product-area">
                                <?php
                                include 'sort.php';
                                ?>                                
                                <div class="aa-product-catg-body">
                                    <ul class="aa-product-catg">
                                        <?php
                                        foreach($showCategory->goods as $good) {
                                            $good->showInCatalog();
                                        }
                                        ?>
                                    </ul>
                                    <div id="empty-catg" class="aa-empty-catg" hidden>Мы не нашли товаров, удовлетворяющих вашему запросу</div>
                                </div>
                            </div>  
                            <?php
                            include 'modalgood.php';
                            ?>
                        </div>
                    </div>
                <?php
                    $hideFilterCat = true;
                    include 'filter.php';
                } else {
                ?>
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <ul class="aa-product-catg">
                                <?php
                                foreach($categories as $category) {
                                ?>    
                                <li class="col-sm-3 good">
                                  <figure>
                                    <a class="aa-product-img" href="/catalog/category/<?php echo $category->url ?>"><img src="/images/category/category<?php echo $category->id ?>.png" alt="<?php echo $category->name ?>"></a>
                                    <figcaption>
                                        <h4 class="aa-product-title"><a href="/catalog/category/<?php echo $category->url ?>"><?php echo $category->name ?></a></h4>
                                    </figcaption>
                                  </figure>                         
                                </li> 
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php
                }
                ?>
                </div>
            </div>    
        </div>
    </div>
</section>

<?php
include 'footer.php';


