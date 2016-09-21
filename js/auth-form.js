$("#login-modal").on("shown.bs.modal", function () {
    showLoginForm();
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

    $.ajax({ 
        type: "POST",   
        url: "/register",   
        data: "userName=" + name + "&userEmail=" + email + "&userPassword=" + pass + "&userConfirm=" + confirm + "&isSpam=" + spam + "&userAction=" + action,   // формируем строку с переменными
        dataType: "html",   
        dataFilter: function(a) {   
            return $(a).filter("#error").html(); 
        },   
        success: function(a) {  
            if(a === null) {   
                window.location.reload();    
            }
            else {  
                $("#auth-error").css("display", "inline-block");
                $("#auth-error").html(a);   
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