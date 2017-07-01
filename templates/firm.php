<?php
include 'header.php';
?>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="aa-product-header">
                <h1>Наши бренды</h1>
                <p>Мы торгуем только товарами проверенных годами фирм</p>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <ul class="aa-product-catg">
                                <?php
                                foreach($firms as $id=>$firm) {
                                ?>    
                                <li class="col-sm-3 good">
                                    <figure>
                                        <a class="aa-product-img" href="/catalog/firm/<?php echo $firm->url ?>"><img src="/images/firms/firm<?php echo $id ?>.png" alt="<?php echo $firm->name ?>"></a>
                                        <figcaption>
                                            <h4 class="aa-product-title"><a href="/catalog/firm/<?php echo $firm->url ?>"><?php echo $firm->name ?></a></h4>
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


