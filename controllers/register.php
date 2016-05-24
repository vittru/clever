<?php

Class Controller_Register Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(16);
        $error =  $this->isCorrect();
        if ($error == ""){
            $this->registry->set('userName', htmlspecialchars(trim($_POST['userName'])));
            $this->registry->set('userEmail', htmlspecialchars(trim($_POST['userEmail'])));
            if (isset($_POST['userPassword']) && $_POST['userPassword'] != "") {
                $this->registry->set('userPassword', $_POST['userPassword']);
            }
            if ($_POST['isClient'] == "true"){
                $this->registry->set('isClient', '1');
            }else{
                $this->registry->set('isClient', '0');
            }
            if ($_POST['isSpam'] == "true"){
                $this->registry->set('isSpam', '1');
            }else{
                $this->registry->set('isSpam', '0');
            }
            if ($_POST['userAction'] != "login")
                $this->registry['model']->updateUser();
            else 
                $this->registry['model']->login();
        } else {
            $error = "<div id='error'>" . $error . "</div>";
        }
        echo $error;
    }
    
    function isCorrect() {
        $action = $_POST['userAction'];
        $error = "";
        if ($action != 'login' && trim($_POST['userName']) == "") $error = $error . "Пустое имя пользователя<br>";
	if ($action != 'update' && $_POST['userPassword'] == "") $error = $error .  "Пустой пароль<br>";
	if (trim($_POST['userEmail']) == "") {
            $error = $error .  "Пустой email<br>"; 
        } else {
            if (!preg_match('/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/is', trim($_POST['userEmail']))) $error = $error . "Ваша почта кажется нам подозрительной<br>";
            else
                if ($action != 'login' && $this->registry['userEmail'] != $_POST['userEmail'] && $this->registry['model']->checkEmailExists($_POST['userEmail'])) $error = $error .  "К сожалению кто-то уже зарегистрировал этот email у нас на сайте<br>";
            }
        if ($action != 'login' && $_POST['userPassword'] != $_POST['userConfirm']) $error = $error .  "Ваши пароли не совпадают<br>"; 
	if ($action == 'login' && $error == '' && !$this->registry['model']->checkUser($_POST['userEmail'], $_POST['userPassword'])) $error = $error . "К сожалению такого пользователя у нас нет<br>";
        return $error; 
    }
    
}

