<?php
include 'header.php';
?>

<link href="/css/lightbox.css" rel="stylesheet">
<section id="editgood">
    <form method="post" action="/sale/save" enctype="multipart/form-data">
        <table class="table">
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="sale">Скидка:</label>
                        <input type="number" class="form-control col-md-9 inline" id="sale" name="sale" value='0'>
                        <label class="col-md-1">%</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label for="brand" class="col-md-2">Бренд:</label>
                        <div class="col-md-10">
                        <?php
                        foreach ($this->registry['firms'] as $key => $firm) {
                        ?>
                            <label class="checkbox-inline" style="margin: 0 10px 0 0;"><input type="checkbox" value="" name="firm<?php echo $key ?>"><?php echo $firm->name ?></label>
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
                        <label class="col-md-2">Для кого:</label>
                        <div class="col-md-10">
                        <?php
                        foreach ($this->registry['types'] as $id => $type) {
                        ?>
                            <label class="checkbox-inline" style="margin: 0 10px 0 0;"><input type="checkbox" value="" name="mentype<?php echo $id ?>"><?php echo $type->name ?></label>
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
                        <label class="col-md-2">Тип:</label>
                        <div class="col-md-10 columns">
                        <?php
                        foreach ($this->registry['supercats'] as $scat) {
                        ?>
                            <label class="checkbox-inline"><input type="checkbox" value="" name="superc<?php echo $scat->id ?>"><?php echo $scat->name ?></label>
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
                            <label class="checkbox-inline"><input type="checkbox" value="" name="cat<?php echo $key ?>"><?php echo $value ?></label>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td> 
                    Скидка не распространяется на наборы и подарки, если они явно не выбраны.
                </td>
            </tr>
        </table>
        <button type="submit" style="margin-bottom: 40px;" class="btn green-button" id="save">Сохранить</button>
    </form>
</section>

<?php
include 'footer.php';