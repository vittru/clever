    function showRegForm() {
        loginTab = document.getElementById("loginTab");
        loginTab.setAttribute("class", "auth-tab link");
        loginTab.setAttribute("onclick", "showLoginForm()");
        regTab = document.getElementById("regTab");
        regTab.setAttribute("class", "auth-tab");
        regTab.setAttribute("onclick", "");
        document.getElementById("auth-error").style.display="none";
        document.getElementById("auth-action").setAttribute("value", "register");
        var regElements = document.getElementsByClassName('nologin');
        var i;
        for (i = 0; i < regElements.length; i++) {
            regElements[i].style.display='inline-block';
        }
        document.getElementById('auth-name').focus();
    }

    function showLoginForm() {
        loginTab = document.getElementById("loginTab");
        loginTab.setAttribute("class", "auth-tab");
        loginTab.setAttribute("onclick", "");
        document.getElementById("auth-action").setAttribute("value", "login");
        regTab = document.getElementById("regTab");
        regTab.setAttribute("class", "auth-tab link");
        regTab.setAttribute("onclick", "showRegForm()");
        document.getElementById("auth-error").style.display="none";
        var regElements = document.getElementsByClassName('nologin');
        var i;
        for (i = 0; i < regElements.length; i++) {
            regElements[i].style.display='none';
        }
        document.getElementById('auth-email').focus();
    }
    
    document.getElementById("auth-header").innerHTML="<div id='loginTab' class='auth-tab'>Вход</div>/<div id='regTab' class='auth-tab link' onclick='showRegForm()'>Регистрация</div>";
    document.getElementById("auth-action").setAttribute("value", "login");

    document.getElementById('register').onclick = function() {
      showPrompt(true);
    };


