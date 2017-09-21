<?php
include 'header.php';

?>

<section id="editgood">
    <form method="post" action="/mailout/send" enctype="multipart/form-data">
        <table class="table">
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="header">Заголовок:</label>
                        <textarea class="form-control col-md-10 text" rows="2" id="header" name="header" maxlength="500"></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>  
                    <div class="form-group">
                        <label class="col-md-2" for="text">Текст:</label>
                        <div class="form-control col-md-10 text" id="description" name="textHtml"></div>
                        <textarea hidden id="text" name="text"></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="col-md-2" for="image">Картинка</label>
                    <input class="form-control col-md-10 text" type="file" name="image" id="image"> 
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
        </table>
        <button type="submit" style="margin-bottom: 40px;" class="btn green-button" id="send">Разослать</button>
    
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
    $('#send').click(function () {
        var mysave =  $('#description').summernote('code');
        $('#text').val(mysave);
        var tmp = document.createElement("DIV");
        tmp.innerHTML = $('#text').val();
        if ($('#header').val().trim()==="" || tmp.innerText.trim()==="") {
            if ($('#header').val().trim()==="") $('#header').addClass('error');
            if (tmp.innerText.trim()==="") $('div.note-editor').addClass('error');
            alert('Заполните заголовок и текст');
            event.preventDefault();
        } 
        else if (!confirm('Отправить рассылку?'))
            event.preventDefault();
    });
});
</script>