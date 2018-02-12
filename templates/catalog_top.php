<?php
include 'header.php';
?>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                include 'breadcrumbs.php';
                ?>
                <div class="row">
                    <div class="aa-product-header">
                        <h1><?php echo $pageHeader ?></h1>
                        <p><?php echo $pageSubHeader ?></p>
                        <h4><?php 
                            echo $pageSecondHeader;
                        ?></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <ul class="aa-product-catg">
                                <?php
                                foreach($objects as $object) {
                                    $ourl = "/catalog/" . $otype . "/" . $object->url;
                                    $oimage = "images/" . $otype . "/" . $otype . $object->id . ".png";
                                    if (!file_exists($oimage))
                                        $oimage = "/images/icon.png";
                                    else
                                        $oimage = "/" . $oimage;
                                ?>    
                                <li class="col-sm-3 category">
                                  <figure>
                                    <a class="aa-product-img" href="<?php echo $ourl ?>"><img src="<?php echo $oimage; ?>" alt="<?php echo $object->name ?>"></a>
                                    <figcaption>
                                        <h4 class="aa-product-title"><a href="<?php echo $ourl ?>"><?php echo $object->name ?></a></h4>
                                    </figcaption>
                                  </figure>                         
                                </li> 
                                <?php
                                } 
                                ?>
                            </ul>
                        </div>
                        <div class="aa-product-desc desc-after">
                            <?php
                            if ($descAfter) {
                                echo $descAfter;
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


