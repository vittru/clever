<?php
if ($isadmin) {
?>
    <a class="green button" style="padding: 12px 15px;" href="/editnews">Добавить новость</a>
<?php
}    
foreach ($news as $new) {
    $image = $new->getImage();
?>
<div class="row news">
    <h2 id="news<?php echo $new->id; ?>"><?php echo $new->header; ?></h2>
    <div class="col-md-12 newstime">
        <?php 
        echo $new->time; 
        if ($new->end) {
            echo " - " . $new->end;
        }
    ?>
    </div>
    <img class="news-image" src=<?php echo $image; ?>>

    <div class="col-md-12">
        <p><?php echo $new->text; ?></p>
        <p>
            <?php
            if ($isadmin) {
            ?>
                <a class="green button" href="/editnews?news=<?php echo $new->id ?>">Редактировать</a>
                <a class="orange button" href="/editnews/remove?news=<?php echo $new->id ?>">Удалить</a>
            <?php
            }    
            ?>
        </p>
    </div>   
</div>
<?php
}


