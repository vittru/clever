<?php
include 'header.php';
$newsId=$_GET['news'];
if ($newsId) {
    $news = $this->registry['model']->getNewsItem($newsId);
} else 
    $news=false;
?>

<link href="/css/lightbox.css" rel="stylesheet">
<section id="editgood">
    <form method="post" action="/editnews/save" enctype="multipart/form-data">
        <table class="table">
            <tr>
                <td>  
                    <input hidden name='id' value='<?php echo $newsId ?>'>
                    <div class="form-group">
                        <label class="col-md-2" for="header">Заголовок:</label>
                        <textarea class="form-control col-md-10 text" rows="2" id="description" name="header" maxlength="500"><?php if ($news) echo $news->header ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="text">Текст:</label>
                        <textarea class="form-control col-md-10 text" rows="5" id="description" name="text"><?php if ($news) echo $news->text ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2">Видимость:</label> 
                        <div class="col-md-10 columns">
                            <label class="checkbox-inline"><input type="checkbox" value="" name="forClients" <?php if ($news and $news->forClients) echo "checked" ?>>Только для клиентов</label>
                        </div>    
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="time">Дата:</label>
                        <input type="date" name="time" id="time" class="form-control col-md-3 inline" value="<?php if ($news) echo date('Y-m-d',strtotime(str_replace('/', '-', trim($news->time)))) ?>">
                        <?php
                        if (!$news) {
                        ?>    
                        <script>
                            document.getElementById('time').valueAsDate = new Date();
                        </script>
                        <?php
                        }
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td> 
                </td>
            </tr>
        </table>
    
    
        <table class="table">
            <tr>
                <td>
                    <?php
                    if ($news and $news->getImage()) {
                    ?>
                        <a href="<?php echo $news->getImage(); ?>" data-lightbox="lightbox" data-title='' class="col-md-2">
                            <img width="100px" src="<?php echo $news->getImage(); ?>" class="img-responsive">
                        </a> 
                    <?php
                    } else {
                    ?>
                        <div class="col-md-2">
                            <img width="100px" src="/images/news/news0.png" class="img-responsive">
                        </div>
                    <?php
                    }
                    ?>  
                    <input class="form-control col-md-10 text" type="file" name="image" id="image"> 
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
?>
