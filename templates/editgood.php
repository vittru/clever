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
                        <?php
                        foreach ($this->registry['firms'] as $key => $firm) {
                        ?>
                            <option value="firm<?php echo $key ?>" <?php if ($good && $good->firmId == $key) echo "selected" ?>><?php echo $firm->name ?></option>
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
                        foreach ($this->registry['types'] as $key => $value) {
                        ?>
                            <label class="checkbox-inline" style="margin: 0 10px 0 10px;"><input type="checkbox" value="" name="mentype<?php echo $key ?>" <?php if (in_array($value, $good->types)) echo "checked" ?>><?php echo $value ?></label>
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
                    <th>Скидка</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php 
                        if ($good)
                            $sizes = array_values($good->sizes);
                        ?>
                        <input class="form-control" type="hidden" id="sizeId1" name="sizeId1" value="<?php 
                        if ($good) {
                            echo $sizes[0]->id;
                        }?>">
                        <input class="form-control" type="text" id="size1" name="size1" value='<?php 
                        if ($good) {
                            echo $sizes[0]->size;
                        }?>' maxlength="10">
                    </td>
                    <td>
                        <input class="form-control" type="number" id="price1" name="price1" value='<?php 
                        if ($good) {
                            echo $sizes[0]->price;
                        }?>'>
                    </td>
                    <td>
                        <input class="form-control" type="text" id="code1" name="code1" value='<?php 
                        if ($good) {
                            echo $sizes[0]->code;
                        }?>' maxlength="10">
                    </td>
                    <td>
                        <input class="form-control" type="number" id="instock1" name="instock1" value='<?php 
                        if ($good and $sizes[0]) {
                            echo $sizes[0]->instock;
                        }else {
                            echo 0;
                        } ?>'>
                    </td>
                    <td>
                        <input class="form-control" type="number" id="sale1" name="sale1" value='<?php 
                        if ($good and $sizes[0]) {
                            echo $sizes[0]->sale;
                        }else {
                            echo 0;
                        } ?>'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="form-control" type="hidden" id="sizeId2" name="sizeId2" value="<?php 
                        if ($good) {
                            echo $sizes[1]->id;
                        }?>">
                        <input class="form-control" type="text" id="size2" name="size2" value='<?php 
                        if ($good) {
                            echo $sizes[1]->size;
                        }?>' maxlength="10">
                    </td>
                    <td>
                        <input class="form-control" type="number" id="price2" name="price2" value='<?php 
                        if ($good) {
                            echo $sizes[1]->price;
                        }?>'>
                    </td>
                    <td>
                        <input class="form-control" type="text" id="code2" name="code2" value='<?php 
                        if ($good) {
                            echo $sizes[1]->code;
                        }?>' maxlength="10">
                    </td>
                    <td>
                        <input class="form-control" type="number" id="instock2" name="instock2" value='<?php 
                        if ($good and $sizes[1]) {
                            echo $sizes[1]->instock;
                        }else {
                            echo 0;
                        } ?>'>
                    </td>
                    <td>
                        <input class="form-control" type="number" id="sale2" name="sale2" value='<?php 
                        if ($good and $sizes[1]) {
                            echo $sizes[1]->sale;
                        }else {
                            echo 0;
                        } ?>'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="form-control" type="hidden" id="sizeId3" name="sizeId3" value="<?php 
                        if ($good) {
                            echo $sizes[2]->id;
                        }?>">
                        <input class="form-control" type="text" id="size3" name="size3" value='<?php 
                        if ($good) {
                            echo $sizes[2]->size;
                        }?>' maxlength="10">
                    </td>
                    <td>
                        <input class="form-control" type="number" id="price3" name="price3" value='<?php 
                        if ($good) {
                            echo $good->sizes[2]->price;
                        }?>'>
                    </td>
                    <td>
                        <input class="form-control" type="text" id="code3" name="code3" value='<?php 
                        if ($good) {
                            echo $sizes[2]->code;
                        }?>' maxlength="10">
                    </td>
                    <td>
                        <input class="form-control" type="number" id="instock3" name="instock3" value='<?php 
                        if ($good and $sizes[2]) {
                            echo $sizes[2]->instock;
                        }else {
                            echo 0;
                        } ?>'>
                    </td>
                    <td>
                        <input class="form-control" type="number" id="sale3" name="sale3" value='<?php 
                        if ($good and $sizes[2]) {
                            echo $sizes[2]->sale;
                        }else {
                            echo 0;
                        } ?>'>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
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
        <button type="submit" style="margin-bottom: 40px;" class="btn btn-success">Сохранить</button>
    
    </form>
</section>

<?php
include 'footer.php';
?>