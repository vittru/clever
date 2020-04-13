<?php
include 'header.php';
?>
<link href="/css/lightbox.css" rel="stylesheet">
<section id="addgoods">
    <form method="post" action="/addgoods/add" enctype="multipart/form-data" id="addgoodsform">
        <table class="table">
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
        </table>
    
        <table class="table">
            <tr>
                <td>
                    <input class="form-control col-md-10 text" type="file" name="csv" id="csv"> 
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
        </table>
        <button type="submit" style="margin-bottom: 40px;" class="btn green button" id="save">Сохранить</button>
    
    </form>
</section>

<?php
include 'footer.php';

?>

<link href="/css/clubclever-admin.min.css" rel="stylesheet">