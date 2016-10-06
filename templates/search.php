<?php
include 'header.php';
?>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-header">
                    <h3>Вы искали</h3>
                    <p><?php
                    foreach($_GET as $key => $value){
                        if (!empty($value) and $key!="route") {
                            switch ($key) {
                                case "name":
                                    echo "Tекст: ".$value."<br>";
                                    break;
                                case "effect":
                                    echo "Эффект: ".$this->registry['effects'][$value]."<br>";
                                    break;
                                case "hairtype":
                                    echo "Тип волос: ".$this->registry['hairtypes'][$value]."<br>";
                                    break;
                                case "skintype":
                                    echo "Тип кожи: ".$this->registry['skintypes'][$value]."<br>";
                                    break;
                                case "firm":    
                                    echo "Бренд: ".$this->registry['firms'][$value]->name."<br>";
                                    break;
                                case "problem":    
                                    echo "Проблема: ".$this->registry['problems'][$value]."<br>";
                                    break;
                                case "description":
                                    echo "Описание: ".$value."<br>";
                                    break;                        
                                case "howTo":
                                    echo "Способ применения: ".$value."<br>";
                                    break;
                                case "madeOf":
                                    echo "Состав: ".$value."<br>";
                                    break;
                                case "category":
                                    echo "Категория: ".$this->registry['categories'][$value]."<br>";
                                    break;
                            }
                        }
                    }
                    ?></p>
                    <h4><?php 
                    if (count($foundgoods))
                        echo "Мы нашли товаров: " . count($foundgoods);
                    else
                        echo "К сожалению таких товаров нет"
                    ?></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <div class="tab-content">
                                <div class="tab-pane fade in active">
                            <?php
                            if (count($foundgoods))include 'sort.php';
                            ?>                                
                                    <ul class="aa-product-catg">
                            <?php
                                foreach($foundgoods as $goodid=>$good) {
                                    $good->showInCatalog();
                                }
                            ?>
                                    </ul>
                                </div>
                            </div>    
                        </div>
                    </div>  
                    <?php
                    include 'modalgood.php';
                    ?>
                </div>
            </div>    
        </div>
    </div>
</section>

<?php
include 'footer.php';

