<?php
include 'header.php';
$blogId=$_GET['blog'];
if ($blogId) {
    $blog = $this->registry['model']->getBlogEntry($blogId);
} else 
    $blog = false;
?>

<link href="/css/lightbox.css" rel="stylesheet">
<section id="editgood">
    <form method="post" action="/editblog/save" enctype="multipart/form-data">
        <table class="table">
            <tr>
                <td>  
                    <input hidden name='id' value='<?php echo $blogId ?>'>
                    <div class="form-group">
                        <label class="col-md-2" for="header">Заголовок:</label>
                        <textarea class="form-control col-md-10 text" rows="2" id="header" name="header" maxlength="500"><?php if ($blog) echo $blog->name ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="author">Автор:</label>
                        <textarea class="form-control col-md-10 text" rows="1" id="author" name="author" maxlength="500"><?php if ($blog) echo $blog->author ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="url">Источник:</label>
                        <textarea class="form-control col-md-10 text" rows="1" id="url" name="url" maxlength="500"><?php if ($blog) echo $blog->url ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if ($blog) {
                    ?>
                        <a href="<?php echo $blog->getImage() ?>" data-lightbox="lightbox" data-title='' class="col-md-2">
                            <img width="100px" src="<?php echo $blog->getImage(); ?>" class="img-responsive">
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
                    <label for="image">Картинка для блога должна быть квадратной</label>
                    <input class="form-control col-md-10 text" type="file" name="image" id="image"> 
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="date">Дата публикации:</label>
                        <input type="date" name="date" id="date" class="form-control col-md-3 inline" value="<?php if ($blog) echo date('Y-m-d',strtotime(str_replace('/', '-', trim($blog->date)))) ?>">
                        <?php
                        if (!$blog) {
                        ?>    
                        <script>
                            document.getElementById('date').valueAsDate = new Date();
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
                        <label class="col-md-2" for="text">Текст:</label>
                        <div class="form-control col-md-10 text" id="description" name="textHtml"><?php if ($blog) echo $blog->text ?></div>
                        <textarea hidden id="text" name="text"></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td> 
                </td>
            </tr>
        </table>
        <button type="submit" style="margin-bottom: 40px;" class="btn green-button" id="save">Сохранить</button>
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
  $('#description').summernote();
});

$(function(){
    $('#save').click(function () {
        var mysave =  $('#description').summernote('code');
        $('#text').val(mysave);
    });
});
</script>