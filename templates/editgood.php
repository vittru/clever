<?php
include 'header.php';
$goodId=$_GET['good'];
if ($goodId) {
    $good = $this->registry['model']->getGood($goodId);
}        
?>


<form method="post" action="/editgood/save">
    <input hidden name='id' value='<?php echo $goodId ?>'>
    <div class="form-group">
        <label for="name">Имя:</label>
        <input type="text" class="form-control" id="name" name="name" value='<?php if ($good) echo $good->name ?>'>
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
        <label for="">Категория:</label>
        <?php
        foreach ($this->registry['categories'] as $key => $value) {
            ?>
            <label class="checkbox-inline"><input type="checkbox" value="" name="cat<?php echo $key ?>" <?php if (in_array($key, $good->cats)) echo "checked" ?>><?php echo $value ?></label>
            <?php
        }
        ?>
    </div>

    <div class="form-group">
        <label for="">Проблема:</label>    
        <?php
        foreach ($this->registry['problems'] as $key => $value) {
            ?>
            <label class="checkbox-inline"><input type="checkbox" value="" name="prob<?php echo $key ?>" <?php if (in_array($key, $good->probs)) echo "checked" ?>><?php echo $value ?></label>
            <?php
        }
        ?>
    </div>
        
    <div class="form-group">
        <label for="">Эффект:</label>    
        <?php
        foreach ($this->registry['effects'] as $key => $value) {
            ?>
            <label class="checkbox-inline"><input type="checkbox" value="" name="eff<?php echo $key ?>" <?php if (in_array($key, $good->effs)) echo "checked" ?>><?php echo $value ?></label>
            <?php
        }
        ?>
    </div>

    <div class="form-group">
        <label for="">Тип кожи:</label>    
        <?php
        foreach ($this->registry['skintypes'] as $key => $value) {
            ?>
            <label class="checkbox-inline"><input type="checkbox" value="" name="skintype<?php echo $key ?>" <?php if (in_array($key, $good->skintypes)) echo "checked" ?>><?php echo $value ?></label>
            <?php
        }
        ?>
    </div>

    <div class="form-group">
        <label for="">Тип волос:</label>    
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
        <label for="sale">Скидка:</label>
        <input type="text" class="form-control" id="sale" name="sale" value='<?php 
            if ($good) {
                echo $good->sale;
            } else {
                echo 0;
            }  ?>'>
        <label>%</label>
    </div>
    
    <button type="submit" class="btn btn-success">Сохранить</button>
    
</form>


<?php
include 'footer.php';
?>

