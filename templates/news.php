<?php

include 'header.php';
?>
<link href="/css/lightbox.css" rel="stylesheet">

<section id="aa-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Наши новости</h1>
                <?php
                foreach ($news as $new) {
                    $image = $new->getImage();
                ?>
                <div class="row news">
                    <!--div class="col-md-12"-->
                        <h2><?php echo $new->header; ?></h2>
                        <div class="col-md-12 newstime"><?php echo $new->time; ?></div>
                        <div class="col-md-8"><p><?php echo $new->getWebText(); ?></p></div>   
                        <div class="col-md-4">
                            <a href="<?php echo $image; ?>" data-lightbox="lightbox" data-title='<?php echo $new->header ?>'>
                                <img src="<?php echo $image; ?>">
                            </a>
                        </div>
                    <!--/div-->
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>    
<?php
include 'footer.php';