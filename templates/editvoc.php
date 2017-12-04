<?php
include 'header.php';
?>

<link href="/css/lightbox.css" rel="stylesheet">
<section id="editgood">
    <form method="post" action="/editvoc/save" enctype="multipart/form-data">
        <table class="table">
            <tr>
                <td>  
                    <input hidden name='id' value='<?php if ($editWord) echo $editWord['id'] ?>'>
                    <div class="form-group">
                        <label class="col-md-2" for="name">Слово:</label>
                        <textarea class="form-control col-md-10 text" rows="1" id="name" name="name" maxlength="100"><?php if ($editWord) echo $editWord['name'] ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="text">Значение:</label>
                        <div class="col-md-10" style="padding-left:0px">
                            <div class="form-control text" id="description" name="textHtml"><?php if ($editWord) echo $editWord['value'] ?></div>
                            <textarea hidden id="text" name="text"></textarea>
                        </div>    
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
        result = mysave.replace(/(<p[^>]+?>|<p>|<\/p>)/img, "");
        $('#text').val(result);
    });
});
</script>