<?php
include 'header.php';
$goodId=$_GET['good'];
if ($goodId) {
    $good = $this->registry['model']->getGood($goodId);
} else 
    $good=false;
?>


<form method="post" action="/editgood/save" enctype="multipart/form-data" id="editgood">
    <input hidden name='id' value='<?php echo $goodId ?>'>
    <div class="form-group">
        <label for="name">Имя:</label>
        <input type="text" class="form-control" id="name" name="name" value='<?php if ($good) echo $good->name ?>'>
    </div>  
    
    <div class="form-group">
      <label for="shortdesc">Краткое описание:</label>
      <textarea class="form-control" rows="2" id="description" name="shortdesc"><?php if ($good) echo $good->shortdesc ?></textarea>
    </div>

    <div class="form-group">
      <label for="description">Описание:</label>
      <textarea class="form-control" rows="5" id="description" name="description"><?php if ($good) echo $good->description ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="brand">Производитель:</label>
        <select class="form-control" id="brand" name="brand">
            <?php
            foreach ($this->registry['firms'] as $key => $value) {
                ?>
                <option value="firm<?php echo $key ?>" <?php if ($good && $good->firmId == $key) echo "selected" ?>><?php echo $value ?></option>
                <?php
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Для кого:</label>
        <?php
        foreach ($this->registry['types'] as $key => $value) {
            ?>
            <label class="checkbox-inline"><input type="checkbox" value="" name="mentype<?php echo $key ?>" <?php if (in_array($value, $good->types)) echo "checked" ?>><?php echo $value ?></label>
            <?php
        }
        ?>
    </div>
    
    
    <div class="form-group">
        <label>Категория:</label>
        <?php
        foreach ($this->registry['categories'] as $key => $value) {
            ?>
            <label class="checkbox-inline"><input type="checkbox" value="" name="cat<?php echo $key ?>" <?php if (in_array($key, $good->cats)) echo "checked" ?>><?php echo $value ?></label>
            <?php
        }
        ?>
    </div>
        
    <div class="form-group">
        <label>Эффект:</label>    
        <?php
        foreach ($this->registry['effects'] as $key => $value) {
            ?>
            <label class="checkbox-inline"><input type="checkbox" value="" name="eff<?php echo $key ?>" <?php if (in_array($key, $good->effs)) echo "checked" ?>><?php echo $value ?></label>
            <?php
        }
        ?>
    </div>

    <div class="form-group">
        <label>Тип кожи:</label>    
        <?php
        foreach ($this->registry['skintypes'] as $key => $value) {
            ?>
            <label class="checkbox-inline"><input type="checkbox" value="" name="skintype<?php echo $key ?>" <?php if (in_array($key, $good->skintypes)) echo "checked" ?>><?php echo $value ?></label>
            <?php
        }
        ?>
    </div>

    <div class="form-group">
        <label>Тип волос:</label>    
        <?php
        foreach ($this->registry['hairtypes'] as $key => $value) {
            ?>
            <label class="checkbox-inline"><input type="checkbox" value="" name="hairtype<?php echo $key ?>" <?php if (in_array($key, $good->hairtypes)) echo "checked" ?>><?php echo $value ?></label>
            <?php
        }
        ?>
    </div>
    
    <div class="form-group">
        <label for="madeOf">Состав:</label>
        <textarea class="form-control" rows="3" id="madeOf" name="madeOf"><?php if ($good) echo $good->madeOf ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="howTo">Способ применения:</label>
        <textarea class="form-control" rows="3" id="howTo" name="howTo"><?php if ($good) echo $good->howTo ?></textarea>
    </div>

    <div class="form-group">
        <label for="problem">Проблема:</label>
        <textarea class="form-control" rows="3" id="howTo" name="problem"><?php if ($good) echo $good->problem ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="sale">Скидка:</label>
        <input type="text" class="form-control" id="sale" name="sale" value='<?php 
            if ($good) {
                echo $good->sale;
            } else {
                echo 0;
            }  ?>'>
        <label>%</label>
    </div>
      
    
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
            }?>'>
        </td>
        <td><input class="form-control" type="text" id="price1" name="price1" value='<?php 
            if ($good) {
                echo $sizes[0]->price;
            }?>'>
        </td>
        <td><input class="form-control" type="text" id="code1" name="code1" value='<?php 
            if ($good) {
                echo $sizes[0]->code;
            }?>'>
        </td>
        <td><input class="form-control" type="text" id="instock1" name="instock1" value='<?php 
            if ($good and $sizes[0]) {
                echo $sizes[0]->instock;
            }else {
                echo 0;
            } ?>'>
        </td>
        <td><input class="form-control" type="text" id="sale1" name="sale1" value='<?php 
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
            }?>'>
        </td>
        <td><input class="form-control" type="text" id="price2" name="price2" value='<?php 
            if ($good) {
                echo $sizes[1]->price;
            }?>'>
        </td>
        <td><input class="form-control" type="text" id="code2" name="code2" value='<?php 
            if ($good) {
                echo $sizes[1]->code;
            }?>'>
        </td>
        <td><input class="form-control" type="text" id="instock2" name="instock2" value='<?php 
            if ($good and $sizes[1]) {
                echo $sizes[1]->instock;
            }else {
                echo 0;
            } ?>'>
        </td>
        <td><input class="form-control" type="text" id="sale2" name="sale2" value='<?php 
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
            }?>'>
        </td>
        <td><input class="form-control" type="text" id="price3" name="price3" value='<?php 
            if ($good) {
                echo $good->sizes[2]->price;
            }?>'>
        </td>
        <td><input class="form-control" type="text" id="code3" name="code3" value='<?php 
            if ($good) {
                echo $sizes[2]->code;
            }?>'>
        </td>
        <td><input class="form-control" type="text" id="instock3" name="instock3" value='<?php 
            if ($good and $sizes[2]) {
                echo $sizes[2]->instock;
            }else {
                echo 0;
            } ?>'>
        </td>
        <td><input class="form-control" type="text" id="sale3" name="sale3" value='<?php 
            if ($good and $sizes[2]) {
                echo $sizes[2]->sale;
            }else {
                echo 0;
            } ?>'>
        </td>
      </tr>
    </tbody>
  </table>        
  <input class="form-control" type="file" name="image1" id="image1">          
  <input class="form-control" type="file" name="image2" id="image2">          
  <input class="form-control" type="file" name="image3" id="image3">          
            
    <button type="submit" class="btn btn-success">Сохранить</button>
    
</form>


<?php
include 'footer.php';
?>

