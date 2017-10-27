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
                        <textarea class="form-control col-md-10 text" rows="2" id="header" name="header" maxlength="500"><?php if ($news) echo $news->header ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="text">Текст:</label>
                        <div class="col-md-10">
                            <div class="form-control text" id="descriptionHtml" name="textHtml"><?php if ($news) echo $news->text ?></div>
                            <textarea hidden id="description" name="text"></textarea>
                        </div>    
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
                        <label class="col-md-2">Баннер:</label> 
                        <div class="col-md-10 columns">
                            <label class="checkbox-inline"><input type="checkbox" value="" name="banner" <?php if ($news and $news->banner) echo "checked" ?>>Показывать баннер</label>
                        </div>    
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2">Ссылка для баннера:</label> 
                        <input type="text" class="form-control col-md-10 text" maxlength="100" value="<?php if ($news) echo $news->bannerlink ?>" name="bannerlink"/>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="time">Дата публикации:</label>
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
                    <div class="form-group">
                        <label class="col-md-2" for="end">Дата окончания:</label>
                        <input type="date" name="end" id="end" class="form-control col-md-3 inline" value="<?php if ($news and $news->end) echo date('Y-m-d',strtotime(str_replace('/', '-', trim($news->end)))) ?>">
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
                    <label for="image">Картинка для баннера должны быть размером 800х292</label>
                    <input class="form-control col-md-10 text" type="file" name="image" id="image"> 
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
        </table>
        <button id="save" type="submit" style="margin-bottom: 40px;" class="btn green-button">Сохранить</button>
    
    </form>
</section>

<?php
include 'footer.php';

?>

<!-- include summernote css/js-->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.js"></script>

<script>
$(document).ready(function() {
  $('#descriptionHtml').summernote();
});

$(function(){
    $('#save').click(function () {
        var mysave =  $('#descriptionHtml').summernote('code');
        $('#description').val(mysave);
    });
});
</script>