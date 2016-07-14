<?php
    $selmenu=2;
    include 'menu.php';
    $widgetCount=1;
?>
<div id='content'>
    <?php
        $newscount = count($news);
        foreach ($news as $newsItem) {
    ?>
            <div class='news' 
    <?php
                if (strlen($newsItem->text) > 200) {
    ?>
                 onclick='showNews()'
    <?php             
                }
    ?>      >
                <div class='news-header'>
    <?php
                    echo $newsItem->header;
    ?>  
                </div>
    <?php
            if ($newsItem->date > $lastVisit) {
    ?>
                <div class='news-new'>
                    Новое
                </div>
    <?php 
            }
    ?>
                <div class='news-date'>
    <?php
                    echo $newsItem->time;
    ?>
                </div>
                <div class='news-text'>
    <?php                
                    echo $newsItem->text;
    ?>
                </div>
            </div> 
    <?php
        }
    ?>
    
</div>

