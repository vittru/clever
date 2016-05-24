<?php 
    include 'menu.php';
    $widgetCount=3;
?>
<div id='content'>
    <?php
    for ($w = 1; $w <= $widgetCount; $w++) {
        ?>
        <div id='widget' style='width:<?php echo floor(100/$widgetCount)-4 ?>%'>Виджет №<?php echo $w ?></div>
    <?php
    } 
    ?>
</div>
