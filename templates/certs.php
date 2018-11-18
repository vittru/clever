<?php
include 'header.php';
?>
<section class="aa-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="center">
                    <?php 
                    if ($showFirm) {
                        echo 'Сертификаты';
                    } else {
                        echo 'Сертификаты по производителям';
                    }
                    ?>
                </h1>
                <?php 
                if ($showFirm) {
                ?>
                    <h4 class="center"><?php echo $showFirm->name;?></h4>
                <?php
                }
                ?>
            </div>
        </div>    
    </div>
</section>
<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <?php
                    if ($showFirm) {
                        $dirname = 'images/certs/firm'.$showFirm->id;
                    ?>
                        <ul class="aa-product-catg">
                        <?php 
                        $dir = new DirectoryIterator($dirname);
                        foreach ($dir as $fileinfo) {
                            if (!$fileinfo->isDot()) {
                            ?>
                                <li class="col-sm-3 category">
                                  <figure>
                                      <a target="blank" class="aa-product-img" href="/images/certs/firm<?php echo $showFirm->id."/".$fileinfo->getFilename() ?>"><img src="/images/certs/cert.png" onmouseover="this.src='/images/certs/cert_orange.png'"
onmouseout="this.src='/images/certs/cert.png'" alt="<?php echo $fileinfo->getFilename() ?>"></a>
                                    <figcaption>
                                        <h4 class="aa-product-title"><a href="/images/certs/firm<?php echo $showFirm->id."/".$fileinfo->getFilename() ?>"><?php echo $fileinfo->getFilename() ?></a></h4>
                                    </figcaption>
                                  </figure>                         
                                </li> 

                            <?php
                            }
                        }
                        ?>
                        </ul>
                    <?php
                    } else {
                    ?>
                        <ul class="aa-product-catg">
                            <?php
                            foreach($firms as $id=>$firm) {
                                if (file_exists('images/certs/firm'.$id)) {
                                ?>    
                                <li class="col-sm-3 category">
                                  <figure>
                                    <a class="aa-product-img" href="/common/certs?firm=<?php echo $id ?>"><img src="/images/firm/firm<?php echo $id ?>.png" alt="<?php echo $firm->name ?>"></a>
                                    <figcaption>
                                        <h4 class="aa-product-title"><a href="/common/certs?firm=<?php echo $id ?>"><?php echo $firm->name ?></a></h4>
                                    </figcaption>
                                  </figure>                         
                                </li> 
                                <?php
                                }
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
</section>

<?php
include 'footer.php';


