/*    
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
    } */
    
    $("#login-modal").on("shown.bs.modal", function (e) {
        showLoginForm();
    /*    $("#auth-error").css('display','none');
        $(".nologin").each(function() {
            $(this).css('display','none');
        });
        $("#auth-email").focus();
    /*    var regElements = document.getElementsByClassName('nologin');
        var i;
        if (register) {
            for (i = 0; i < regElements.length; i++) {
                regElements[i].style.display='none';
            }
            document.getElementById('auth-email').focus();
        } else {
            document.getElementById('auth-password').setAttribute("placeholder", "Сменить пароль");
            document.getElementById('auth-name').focus();
        }  */
    });
    
    
    $("#auth-form").submit(function(e) { 
        e.preventDefault(); 
        submitForm();
    });
    
    function submitForm(){
        var name = $("#auth-name").val(),    
            email = $("#auth-email").val(),
            pass = $("#auth-password").val(),
            confirm = $("#auth-confirm").val(),
            //client = $("#auth-client").prop('checked'),
            spam = $("#auth-spam").prop('checked'),
            action = $("#auth-action").val();
 
        $.ajax({    // Делаем ajax запрос
            type: "POST",   
            url: "register",   
            data: "userName=" + name + "&userEmail=" + email + "&userPassword=" + pass + "&userConfirm=" + confirm + "&isSpam=" + spam + "&userAction=" + action,   // формируем строку с переменными
            dataType: "html",   
            dataFilter: function(a) {   
                return $(a).filter("#error").html(); 
            },   
            success: function(a) {  
                if(a == null) {   
                    window.location.reload();    
                }
                else {  // в другом случае
                    $("#auth-error").css("display", "inline-block");
                    $("#auth-error").html(a);   // выводим ошибку в поле с id="auth-error"
                }
            }
        });
        return 1;
    };
    
    function showRegForm() {
        $('#auth-header').text('Зарегистрироваться');
        $('#auth-error').css('display','none');
        $('#auth-action').val("register");
        $(".nologin").each(function() {
            $(this).css('display','inline-block');
        });
        $('#auth-name').focus();
        $('.aa-register-now').text('Уже зарегистрированы?');
        $('.aa-register-now').append('<a id="auth-register" onclick="showLoginForm()">Войти</a>');
    }
    
    function showLoginForm() {
        $('#auth-header').text('Войти');
        $('#auth-error').css('display','none');
        $('#auth-action').val("login");
        $(".nologin").each(function() {
            $(this).css('display','none');
        });
        $('#auth-email').focus();
        $('.aa-register-now').text('У вас еще нет пароля?');
        $('.aa-register-now').append('<a id="auth-register" onclick="showRegForm()">Зарегистрируйтесь!</a>');
    }


