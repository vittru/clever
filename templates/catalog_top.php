<?php
include 'header.php';
?>
<section class="aa-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                include 'breadcrumbs.php';
                ?>
                <h1 class="center"><?php echo $pageHeader ?></h1>
                <p><?php echo $pageSubHeader ?></p>
                <h4 class="center"><?php echo $pageSecondHeader;?></h4>
            </div>
        </div>    
    </div>
</section>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="aa-product-catg">
                    <?php
                    foreach($objects as $object) {
                        $ourl = "/catalog/" . $otype . "/" . $object->url;
                        $oimage = "images/" . $otype . "/" . $otype . $object->id . ".png";
                        if (!file_exists($oimage)) {
                            $oimage = "/images/icon.png";
                        } else {
                            $oimage = "/" . $oimage;
                        }    
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
        </div>
    </div>
</section>
<?php
if ($descAfter) {
?>
<section class="aa-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                echo $descAfter;
                ?>
            </div>
        </div>    
    </div>  
</section>    
<?php
}
?>

<?php
include 'footer.php';


