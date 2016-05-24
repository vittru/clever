    document.getElementById("auth-header").innerHTML="<div class='auth-tab'>Профиль</div>";
    document.getElementById("auth-action").setAttribute("value", "update");
    
    document.getElementById('profile').onclick = function() {
        showPrompt(false);
    };


