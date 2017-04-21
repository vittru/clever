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
                if ($isadmin) {
                ?>
                    <a class="green-button" style="padding: 12px 15px;" href="/editnews">Добавить новость</a>
                <?php
                }    
                foreach ($news as $new) {
                    $image = $new->getImage();
                ?>
                <div class="row news">
                    <h2><?php echo $new->header; ?></h2>
                    <div class="col-md-12 newstime">
                        <?php 
                        echo $new->time; 
                        if ($new->end)
                            echo " - " . $new->end;
                        ?>
                    </div>
                    <img class="news-image" src=<?php echo $image; ?>>

                    <div class="col-md-12">
                        <p><?php echo $new->getWebText(); ?></p>
                        <p>
                            <?php
                            if ($isadmin) {
                            ?>
                                <a class="green-button" style="padding: 12px 15px;" href="/editnews?news=<?php echo $new->id ?>">Редактировать</a>
                                <a class="orange-button" style="padding: 12px 15px;" href="/editnews/remove?news=<?php echo $new->id ?>">Удалить</a>
                            <?php
                            }    
                            ?>
                        </p>
                    </div>   
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