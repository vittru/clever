<?php

include 'header.php';
?>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <ul class="aa-product-catg">
                                <li class="col-sm-3 good">
                                  <figure>
                                      <a class="aa-product-img" href="/actions/bestbefore"><img src="/images/design/bestbefore.png" alt="Истекающие сроки"></a>
                                    <figcaption>
                                        <h4 class="aa-product-title"><a href="/actions/bestbefore">Истекающие сроки</a></h4>
                                    </figcaption>
                                  </figure>                         
                                </li> 
                                <li class="col-sm-3 good">
                                  <figure>
                                      <a class="aa-product-img" href="/actions/discounts"><img src="/images/design/discount.png" alt="Скидки"></a>
                                    <figcaption>
                                        <h4 class="aa-product-title"><a href="/actions/discounts">Скидки</a></h4>
                                    </figcaption>
                                  </figure>                         
                                </li> 
                            </ul>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</section>
<?php
if (sizeof($news)) {
?>
<section id="aa-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Акции</h1>
                <?php
                include 'listnews.php';
                ?>
            </div>
        </div>
    </div>
</section>    
<?php
}
include 'footer.php';