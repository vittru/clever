<?php
include 'header.php';
?>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-header">
                        <h1>Категории товаров</h1>
                        <p>Мы постоянно стараемся расширить наш ассортимент</p>
                    </div>
                </div>
                <div class="row">
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
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';


