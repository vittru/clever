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
        phone = $("#auth-phone").val(),
        //client = $("#auth-client").prop('checked'),
        flyer = $("#auth-flyer").val(),
        spam = $("#auth-spam").prop('checked'),
        action = $("#auth-action").val();

    $.ajax({ 
        type: "POST",   
        url: "/account/register",   
        data: "userName=" + name + "&userEmail=" + email + "&userPassword=" + pass + "&userConfirm=" + confirm + "&isSpam=" + spam + "&userAction=" + action + "&userPhone=" + phone + "&userFlyer=" + flyer,   
        dataType: "html",   
        dataFilter: function(a) {   
            return $(a).filter("#error").html(); 
        },   
        success: function(a) {  
            if(a == null) { 
                if (action === 'password') {
                    window.location.assign('/account/newpassword');
                } else {
                    if (window.location.pathname.includes('logout') || window.location.pathname.includes('newpassword')) 
                        window.location.assign('/');
                    else    
                        window.location.reload();    
                }
            }
            else {  
                $("#auth-error").show();
                $("#auth-error").html(a);  
                $("#auth-email").focus();
            }
        }
    });
    return 1;
};

function showRegForm() {
    $('#auth-header').text('Зарегистрироваться');
    $('#auth-error').hide();
    $('#auth-action').val("register");
    $(".nologin").each(function() {
        $(this).show();
    });
    $('#auth-password').show();
    $('#auth-name').focus();
    $('#forget-password').hide();
    $('.aa-register-now').text('Уже зарегистрированы?');
    $('.aa-register-now').append('<a id="auth-register" onclick="showLoginForm()">Войти</a>');
}

function showLoginForm() {
    $('#auth-header').text('Войти');
    $('#auth-error').hide();
    $('#auth-action').val("login");
    $(".nologin").each(function() {
        $(this).hide();
    });
    $('#auth-email').focus();
    $('#auth-password').show();
    $('#forget-password').show();
    $('.aa-register-now').text('У вас еще нет пароля?');
    $('.aa-register-now').append('<a id="auth-register" onclick="showRegForm()">Зарегистрируйтесь!</a>');
}

function showPasswordForm() {
    $('#auth-header').text('Сбросить пароль');
    $('#auth-error').hide();
    $('#auth-action').val("password");
    $(".nologin").each(function() {
        $(this).hide();
    });
    $('#auth-email').focus();
    $('#auth-password').hide();
    $('#forget-password').hide();
    $('.aa-register-now').text('У вас еще нет пароля?');
    $('.aa-register-now').append('<a id="auth-register" onclick="showRegForm()">Зарегистрируйтесь!</a>');
    
}