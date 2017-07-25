<?php
include 'header.php';
$goodId=$_GET['good'];
if ($goodId) {
    $good = $this->registry['model']->getGood($goodId);
} else 
    $good=false;
?>
<link href="/css/lightbox.css" rel="stylesheet">
<section id="editgood">
    <form method="post" action="/editgood/save" enctype="multipart/form-data" id="editgood">
        <table class="table">
            <tr>
                <td>  
                    <input hidden name='id' value='<?php echo $goodId ?>'>
                    <div class="form-group">
                        <label class="col-md-2" for="name">Имя:</label>
                        <input type="text" class="form-control text col-md-10" id="name" name="name" value='<?php if ($good) echo $good->name ?>' maxlength="60">
                    </div>  
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="shortdesc">Краткое описание:</label>
                        <textarea class="form-control col-md-10 text" rows="2" id="description" name="shortdesc" maxlength="300"><?php if ($good) echo $good->shortdesc ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="description">Описание:</label>
                        <textarea class="form-control col-md-10 text" rows="5" id="description" name="description"><?php if ($good) echo $good->description ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label for="brand" class="col-md-2">Бренд:</label>
                        <select class="form-control inline col-md-10" id="brand" name="brand">
                            <option value="firm0" <?php if (!$good or !$good->firmId) echo 'selected' ?>>Нет бренда</option> 
                        <?php
                        foreach ($this->registry['firms'] as $key => $firm) {
                        ?>
                            <option value="firm<?php echo $key ?>" <?php if ($good and $good->firmId == $key) echo "selected" ?>><?php echo $firm->name ?></option>
                        <?php
                        }
                        ?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2">Для кого:</label>
                        <div class="col-md-10">
                        <?php
                        foreach ($this->registry['types'] as $id => $type) {
                        ?>
                            <label class="checkbox-inline" style="margin: 0 10px 0 10px;"><input type="checkbox" value="" name="mentype<?php echo $id ?>" <?php if (in_array($type->name, $good->types)) echo "checked" ?>><?php echo $type->name ?></label>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2">Категория:</label>
                        <div class="col-md-10 columns">
                        <?php
                        foreach ($this->registry['categories'] as $key => $value) {
                        ?>
                            <label class="checkbox-inline"><input type="checkbox" value="" name="cat<?php echo $key ?>" <?php if (in_array($key, $good->cats)) echo "checked" ?>><?php echo $value ?></label>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2">Эффект:</label>    
                        <div class="col-md-10 columns">
                        <?php
                        foreach ($this->registry['effects'] as $key => $value) {
                        ?>
                            <label class="checkbox-inline"><input type="checkbox" value="" name="eff<?php echo $key ?>" <?php if (in_array($key, $good->effs)) echo "checked" ?>><?php echo $value ?></label>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2">Тип кожи:</label>  
                        <div class="col-md-10 columns">
                        <?php
                        foreach ($this->registry['skintypes'] as $key => $value) {
                        ?>
                            <label class="checkbox-inline"><input type="checkbox" value="" name="skintype<?php echo $key ?>" <?php if (in_array($key, $good->skintypes)) echo "checked" ?>><?php echo $value ?></label>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2">Тип волос:</label> 
                        <div class="col-md-10 columns">
                        <?php
                        foreach ($this->registry['hairtypes'] as $key => $value) {
                        ?>
                            <label class="checkbox-inline"><input type="checkbox" value="" name="hairtype<?php echo $key ?>" <?php if (in_array($key, $good->hairtypes)) echo "checked" ?>><?php echo $value ?></label>
                        <?php
                        }
                        ?>
                        </div>    
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="madeOf">Состав:</label>
                        <textarea class="form-control col-md-10 text" rows="3" id="madeOf" name="madeOf"><?php if ($good) echo $good->madeOf ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="howTo">Способ применения:</label>
                        <textarea class="form-control col-md-10 text" rows="3" id="howTo" name="howTo"><?php if ($good) echo $good->howTo ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2">Проблема:</label>    
                        <div class="col-md-10 columns">
                        <?php
                        foreach ($this->registry['problems'] as $key => $value) {
                        ?>
                            <label class="checkbox-inline"><input type="checkbox" value="" name="prolist<?php echo $key ?>" <?php if (in_array($key, $good->problems)) echo "checked" ?>><?php echo $value ?></label>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="bestbefore">Срок хранения:</label>
                        <textarea class="form-control col-md-10 text" rows="3" id="bestbefore" name="bestbefore" maxlength="200"><?php if ($good) echo $good->bestbefore ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="precaution">Противопоказания:</label>
                        <textarea class="form-control col-md-10 text" rows="3" id="howTo" name="precaution" maxlength="200"><?php if ($good) echo $good->precaution ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="sale">Скидка:</label>
                        <input type="number" class="form-control col-md-9 inline" id="sale" name="sale" value='<?php 
                            if ($good) {
                                echo $good->sale;
                            } else {
                                echo 0;
                            }  ?>'>
                        <label class="col-md-1">%</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td> 
                </td>
            </tr>
        </table>
    
        <table class="table">
            <thead>
                <tr>
                    <th>Размер</th>
                    <th>Цена</th>
                    <th>Артикул</th>
                    <th>На складе</th>
                    <!--th>Скидка</th-->
                    <th>Срок годности</th>
                    <th>Цена СГ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($good)
                    $sizes = array_values($good->sizes);
                for ($i = 0; $i < 3; $i++) {
                ?>
                    <tr>
                        <td>
                            <input class="form-control" type="hidden" id="sizeId<?php echo $i+1 ?>" name="sizeId<?php echo $i+1 ?>" value="<?php 
                            if ($good) {
                                echo $sizes[$i]->id;
                            }?>">
                            <input class="form-control" type="text" id="size<?php echo $i+1 ?>" name="size<?php echo $i+1 ?>" value='<?php 
                            if ($good) {
                                echo $sizes[$i]->size;
                            }?>' maxlength="10">
                        </td>
                        <td>
                            <input class="form-control" type="number" id="price<?php echo $i+1 ?>" name="price<?php echo $i+1 ?>" value='<?php 
                            if ($good) {
                                echo $sizes[$i]->price;
                            }?>'>
                        </td>
                        <td>
                            <input class="form-control" type="text" id="code<?php echo $i+1 ?>" name="code<?php echo $i+1 ?>" value='<?php 
                            if ($good) {
                                echo $sizes[$i]->code;
                            }?>' maxlength="10">
                        </td>
                        <td>
                            <input class="form-control" type="number" id="instock<?php echo $i+1 ?>" name="instock<?php echo $i+1 ?>" value='<?php 
                            if ($good and $sizes[$i]) {
                                echo $sizes[$i]->instock;
                            }else {
                                echo 0;
                            } ?>'>
                        <!--/td-->
                        <!--td-->
                        <input class="form-control" type="hidden" id="sale<?php echo $i+1 ?>" name="sale<?php echo $i+1 ?>" value='<?php 
                            if ($good and $sizes[$i]) {
                                echo $sizes[$i]->sale;
                            }else {
                                echo 0;
                            } ?>'>
                        </td>
                        <td>
                            <input class="form-control" type="date" id="bbsize<?php echo $i+1 ?>" name="bbsize<?php echo $i+1 ?>" value='<?php 
                            if ($good and $sizes[$i]) {
                                echo $sizes[$i]->bestbefore;
                            }?>'>
                        </td>
                        <td>
                            <input class="form-control" type="number" id="bbprice<?php echo $i+1 ?>" name="bbprice<?php echo $i+1 ?>" value='<?php 
                            if ($good) {
                                echo $sizes[$i]->bbprice;
                            }?>'>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="6">
                    </td>
                </tr>    
            </tbody>
        </table>
    
        <table class="table">
            <tr>
                <td>
                    <?php
                    if ($good and $good->getImage()) {
                    ?>
                        <a href="<?php echo $good->getImage(); ?>" data-lightbox="lightbox" data-title='<?php echo $good->name ?>' class="col-md-2">
                            <img width="100px" src="<?php echo $good->getImage(); ?>" class="img-responsive">
                        </a> 
                    <?php
                    } else {
                    ?>
                        <div class="col-md-2">
                            <img width="100px" src="/images/goods/good0.png" class="img-responsive">
                        </div>
                    <?php
                    }
                    ?>  
                    <input class="form-control col-md-10 text" type="file" name="image1" id="image1"> 
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($good and $good->getSecondImage()) {
                    ?>
                        <a href="<?php echo $good->getSecondImage(); ?>" data-lightbox="lightbox" data-title='<?php echo $good->name ?>' class="col-md-2">
                            <img width="100px" src="<?php echo $good->getSecondImage(); ?>" class="img-responsive">
                        </a>
                    <?php
                    } else {
                    ?>
                        <div class="col-md-2">
                            <img width="100px" src="/images/goods/good0.png" class="img-responsive">
                        </div>
                    <?php
                    }
                    ?>
                    <input class="form-control col-md-10 text" type="file" name="image2" id="image2"> 
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($good and $good->getThirdImage()) {
                    ?>
                        <a href="<?php echo $good->getThirdImage(); ?>" data-lightbox="lightbox" data-title='<?php echo $good->name ?>' class="col-md-2">
                            <img width="100px" src="<?php echo $good->getThirdImage(); ?>" class="img-responsive">
                        </a>
                    <?php
                    } else {
                    ?>
                        <div class="col-md-2">
                            <img width="100px" src="/images/goods/good0.png" class="img-responsive">
                        </div>
                    <?php
                    }
                    ?>
                    <input class="form-control col-md-10 text" type="file" name="image3" id="image3">          
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
        </table>
        <button type="submit" style="margin-bottom: 40px;" class="btn green-button">Сохранить</button>
    
    </form>
</section>

<?php
include 'footer.php';