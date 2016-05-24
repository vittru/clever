    
    function showError(str) {
        if (str) {
            document.getElementById('auth-error').style.display='inline-block';
            document.getElementById('auth-error').innerHTML = str;
        } else {
            document.getElementById('auth-error').style.display = 'none';
            
        }
    }
        
    function showCover() {
        var coverDiv = document.createElement('div');
        coverDiv.id = 'modal-placeholder';
        document.body.appendChild(coverDiv);
    }

    function hideCover() {
        document.body.removeChild(document.getElementById('modal-placeholder'));
    }

    function showPrompt(register) {
        showCover();
        var form = document.getElementById('auth-form');
        var container = document.getElementById('auth-form-container');
        container.style.display = 'block';
        document.getElementById('auth-error').style.display='none';
        var regElements = document.getElementsByClassName('nologin');
        var i;
        if (register) {
            for (i = 0; i < regElements.length; i++) {
                regElements[i].style.display='none';
            }
            document.getElementById('auth-email').focus();
        } else {
            document.getElementById('auth-password').setAttribute("placeholder", "Сменить пароль");
            document.getElementById('auth-name').focus();
        }    

        function complete() {
            hideCover();
            container.style.display = 'none';
            document.onkeydown = null;
        }

/*        form.onsubmit = function() {
          var value = form.elements.text.value;
          if (value == '') return false; // игнорировать пустой submit

          complete(value);
          return false;
        };*/

        form.elements.cancel.onclick = function() {
            complete();
        };

        document.onkeydown = function(e) {
            if (e.keyCode == 27) { // escape
                complete();
            }
        };
/*
      var lastElem = form.elements[form.elements.length - 1];
      var firstElem = form.elements[0];

      lastElem.onkeydown = function(e) {
        if (e.keyCode == 9 && !e.shiftKey) {
          firstElem.focus();
          return false;
        }
      };

      firstElem.onkeydown = function(e) {
        if (e.keyCode == 9 && e.shiftKey) {
          lastElem.focus();
          return false;
        }
      };
*/
    }
    
    $("#auth-submit").click(function(e) { 
        e.preventDefault(); 
 
        var name = $("#auth-name").val(),    
            email = $("#auth-email").val(),
            pass = $("#auth-password").val(),
            confirm = $("#auth-confirm").val(),
            client = $("#auth-client").prop('checked'),
            spam = $("#auth-spam").prop('checked'),
            action = $("#auth-action").val();
 
        $.ajax({    // Делаем ajax запрос
            type: "POST",   
            url: "register",   
            data: "userName=" + name + "&userEmail=" + email + "&userPassword=" + pass + "&userConfirm=" + confirm + "&isClient=" + client + "&isSpam=" + spam + "&userAction=" + action,   // формируем строку с переменными
            dataType: "html",   
            dataFilter: function(a) {   
                return $(a).find("#error").text(); },   
            success: function(a) {  
                if(a == '') {   
                    window.location.reload()    
                }
                else {  // в другом случае
                    $("#auth-error").css("display", "inline-block")
                    $("#auth-error").text(a);   // выводим ошибку в поле с id="errors"
                }
            }});
        return 1;
    });



