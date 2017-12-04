<?php
include 'header.php';
?>

<section id="aa-text">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Словарь терминов натуральной косметики</h1>
                <?php
                if ($isadmin) {
                ?>
                <p><a class="green-button" style="padding: 5px 10px;" href="/editvoc">Добавить слово</a></p>
                <?php
                } 
                $currentLetter = "";
                foreach ($words as $word) {
                    $firstLetter = mb_substr($word['name'], 0, 1, 'utf-8');
                    if (strcasecmp($currentLetter, $firstLetter) != 0) {
                        $currentLetter = $firstLetter;
                        echo '<h2>' . $currentLetter . '</h2>';
                    }
                ?>    
                    <p><b><?php echo $word['name']?></b> - <?php echo $word['value'];?>
                    <?php
                    if ($isadmin) {
                    ?>    
                        <a class="orange-button" style="padding: 1px 10px;margin:5px;float:right" href="/editvoc/remove?voc=<?php echo $word['id'] ?>">Удалить</a>
                        <a class="green-button" style="padding: 1px 10px;margin:5px;float:right" href="/editvoc?voc=<?php echo $word['id'] ?>">Редактировать</a>
                    <?php    
                    }
                    ?>
                    </p>
                    <?php    
                }    
                ?>
            </div>    
        </div>
    </div>
</section>    

<?php
include 'footer.php';