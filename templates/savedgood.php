<?php
include 'header.php';
?>

<section class="aa-text">
    <div class='container'>
        <div class='row'>
            <?php
            echo "<h1>Товар сохранен под номером " . $savedGood . "</h1>";
            echo "<p><a href='/editgood?good=".$savedGood ."'>Отредактировать товар</a></p>";
            echo "<p><a href='/editgood'>Создать новый</a></p>";
            echo "<p><a href='/'>На главную</a></p>";
            ?>
        </div>
    </div>
</section>    
<?php    
include 'footer.php';

