<?php
include 'header.php';
?>
<section class="aa-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="center">Экологические товары</h1>
                <p>Мы постарались разбить весь наш ассортимент косметики по категориям для удобства поиска</p>
            </div>
        </div>    
    </div>
</section>
<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <ul class="aa-product-catg">
                        <?php
                        foreach($types as $id=>$type) {
                        ?>    
                        <li class="col-sm-3 category">
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
</section>

<?php
include 'footer.php';


