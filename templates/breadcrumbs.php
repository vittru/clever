<?php
if (sizeof($breadcrumbs)) {
?>
    <div class="row">
        <ul class="breadcrumb">
            <?php
            foreach ($breadcrumbs as $name=>$url) {
                echo '<li>';
                if ($url) {
                    echo '<a href="'. $url . '">';
                }
                echo $name;
                if ($url) {
                    echo '</a>';
                }
                echo '</li>';
            }
            ?>
        </ul>    
    </div>
<?php    
}