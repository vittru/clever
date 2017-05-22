<?php
include 'header.php';
?>

<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-header">
                    <h1>Вы искали</h1>
                    <p><table class="table search-table"><?php
                    foreach($_GET as $key => $value){
                        if (!empty($value) and $key!="route") {
                            switch ($key) {
                                case "type":
                                    echo "<tr><td></td><td class=\"bold\">Товары ".mb_strtolower($this->registry['types'][$value])."</td></tr>";
                                    break;
                                case "name":
                                    echo "<tr><td>Название:</td><td class=\"bold\">".$value."</td></tr>";
                                    break;
                                case "supercat":
                                    echo "<tr><td>Тип:</td><td class=\"bold\">".$this->registry['supercats'][$value]."</td></tr>";
                                    break;
                                case "effect":
                                    echo "<tr><td>Эффект:</td><td class=\"bold\">".$this->registry['effects'][$value]."</td></tr>";
                                    break;
                                case "hairtype":
                                    echo "<tr><td>Тип волос:</td><td class=\"bold\">".$this->registry['hairtypes'][$value]."</td></tr>";
                                    break;
                                case "skintype":
                                    echo "<tr><td>Тип кожи:</td><td class=\"bold\">".$this->registry['skintypes'][$value]."</td></tr>";
                                    break;
                                case "firm":    
                                    echo "<tr><td>Бренд:</td><td class=\"bold\">".$this->registry['firms'][$value]->name."</td></tr>";
                                    break;
                                case "problem":    
                                    echo "<tr><td>Проблема:</td><td class=\"bold\">".$this->registry['problems'][$value]."</td></tr>";
                                    break;
                                case "description":
                                    echo "<tr><td>Описание:</td><td class=\"bold\">".$value."</td></tr>";
                                    break;                        
                                case "howTo":
                                    echo "<tr><td>Способ применения:</td><td class=\"bold\">".$value."</td></tr>";
                                    break;
                                case "madeOf":
                                    echo "<tr><td>Состав:</td><td class=\"bold\">".$value."</td></tr>";
                                    break;
                                case "category":
                                    echo "<tr><td>Категория:</td><td class=\"bold\">".$this->registry['categories'][$value]."</td></tr>";
                                    break;
                            }
                        }
                    }
                    ?><tr><td colspan="2"></td></tr></table></p>
                    <h4><?php 
                    if (count($foundgoods))
                        echo "Мы нашли товаров: " . count($foundgoods);
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
                                    <div id="empty-catg" class="aa-empty-catg" <?php if (count($foundgoods)) echo "hidden"?>>Мы не нашли товаров, удовлетворяющих вашему запросу</div>
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

