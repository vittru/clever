<?php

Class Controller_Subscribe Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(17);
        $error=$this->checkEmail();
        if ($error == "") {
            $this->registry->set('userEmail', htmlspecialchars(trim($_POST['userEmail'])));
            $this->registry->set('isSpam', '1');
            $this->registry['model']->updateUser();
        }
        echo $error;
    }
    
    function checkEmail() {
        $error="";
        if (trim($_POST['userEmail']) == "") {
            $error = $error .  "Пустая почта<br>"; 
        } else {
            if (!preg_match('/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/is', trim($_POST['userEmail']))) $error = $error . "Ваша почта кажется нам подозрительной<br>";
//            else
//                if ($action != 'login' && $this->registry['userEmail'] != $_POST['userEmail'] && $this->registry['model']->checkEmailExists($_POST['userEmail'])) $error = $error .  "К сожалению кто-то уже зарегистрировал эту почту у нас на сайте<br>";
        }
    }
}
