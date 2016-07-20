<?php
include 'header.php';
?>

<section>
</section>    

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <ul class="aa-product-catg">
                            <?php
                                foreach($this->registry['foundgoods'] as $goodid=>$good) {
                                    $good->showInCatalog();
                                }
                            ?>
                            </ul>
                        </div>
                    </div>  
                    <?php
                    include 'modalgood.php';
                    ?>
                </div>
            </div>    
        </div>
    </div>
</section>

<?php
include 'footer.php';

