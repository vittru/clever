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
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <?php
                            if ($showCategory) {
                            ?>
                            <div class="tab-content">
                                <!-- Category -->
                                <div class="tab-pane fade in active" id="<?php echo $showCategory->id ?>">
                                    <?php
                                    include 'sort.php';
                                    ?>
                                    <ul class="aa-product-catg">
                                    <?php
                                    foreach($showCategory->goods as $good) {
                                        $good->showInCatalog();
                                    }
                                    ?>
                                    </ul>
                                </div>
                                <!-- /Category -->
                            </div>  
                            <?php
                            include 'modalgood.php';
                            } else {
                            ?>
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
                            <?php
                            }
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


