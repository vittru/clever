<?php
include 'header.php';
?>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-header">
                        <h1>Экологические товары</h1>
                        <p>Мы постарались разбить весь наш ассортимент косметики по категориям для удобства поиска</p>
                    </div>
                </div>
                <div class="row">
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <ul class="aa-product-catg">
                                <?php
                                foreach($types as $id=>$type) {
                                ?>    
                                <li class="col-sm-3 good">
                                  <figure>
                                    <a class="aa-product-img" href="/catalog/type/<?php echo $type->url ?>"><img src="/images/types/type<?php echo $id ?>.png" alt="<?php echo $type->name ?>"></a>
                                    <figcaption>
                                        <h4 class="aa-product-title"><a href="/catalog/type/<?php echo $type->url ?>"><?php echo $type->name ?></a></h4>
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


