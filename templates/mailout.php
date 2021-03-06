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
                        <div class="col-md-10" style="padding-left:0">
                            <div class="form-control text" id="description" name="textHtml"></div>
                            <textarea hidden id="text" name="text"></textarea>
                        </div>    
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="form-group">
                        <div class="col-md-2">
                            <div class="green button" style="padding: 5px 5px" for="text" id="sendTestEmail">Послать пример на:</div>
                        </div>   
                        <input class="form-control col-md-10 text" id="testEmail" name="textHtml" value="<?php echo $user->email ?>"></input>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
        </table>
        <button type="submit" style="margin-bottom: 40px;" class="btn green button" id="send">Разослать</button>
    
    </form>
</section>

<?php
include 'footer.php';
?>

<!-- include summernote css/js-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.js"></script>

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