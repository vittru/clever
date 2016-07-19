<?php
$firmId=$_GET['id'];
if ($firmId) {
    $firm = $this->registry['model']->getFirm($firmId);
} 
include 'header.php';
?>

<section id="aa-subscribe">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-subscribe-area">
                    <h3><?php echo $firm->name ?> </h3>
                    <p><?php echo $firm->description ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

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
                                foreach($firm->categories as $catId=>$catName) {
                                    ?>
                                <li <?php if ($i==1) echo 'class="active"' ?>><a href="#cat<?php echo $catId ?>" data-toggle="tab"><?php echo $catName ?></a></li>
                                    <?php
                                    $i++;
                                }?>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <?php 
                                $i=0;
                                foreach($firm->categories as $catId=>$catName) {
                                    $i++
                                ?>
                                <!-- Category -->
                                <div class="tab-pane fade <?php if ($i==1) echo 'in active' ?>" id="cat<?php echo $catId ?>">
                                    <ul class="aa-product-catg">
                                    <?php
                                    foreach($firm->goods as $good) {
                                        if (in_array($catId, $good->cats)) {
                                            $good->showInCatalog();
                                        }
                                    }
                                    ?>
                                    </ul>
                                </div>
                                <!-- /Category -->
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

<?php
include 'footer.php';


