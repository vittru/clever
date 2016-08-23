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
                    <h3><?php 
                    if ($firm) 
                        echo $firm->name; 
                    else
                        echo 'Наши бренды';
                    ?></h3>
                    <p><?php if ($firm)
                        echo $firm->description;
                    else 
                        echo 'Мы торгуем только товарами проверенных годами фирм';
                    ?></p>
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
                            <?php
                            if ($firm) {
                            ?>
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
                            <div class="tab-content">
                                <?php 
                                $i=0;
                                foreach($firm->categories as $catId=>$catName) {
                                    $i++
                                ?>
                                <!-- Category -->
                                <div class="tab-pane fade <?php if ($i==1) echo 'in active' ?>" id="cat<?php echo $catId ?>">
                                    <?php
                                    include 'sort.php';
                                    ?>
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
                            } else {
                            ?>
                                <ul class="aa-product-catg">
                                    <?php
                                    foreach($this->registry['firms'] as $id=>$name) {
                                    ?>    
                                    <li class="col-sm-3 good">
                                      <figure>
                                        <a class="aa-product-img" href="/catalog/firm?id=<?php echo $id ?>"><img src="/images/firms/firm<?php echo $id ?>.jpg" alt="<?php echo $name ?>"></a>
                                        <figcaption>
                                            <h4 class="aa-product-title"><a href="/catalog/firm?id=<?php echo $id ?>"><?php echo $name ?></a></h4>
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


