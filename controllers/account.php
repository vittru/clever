<?php

Class Controller_Account Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(27);
        $this->registry['template']->set('orders', $this->registry['model']->getUserOrders($_SESSION['user']->id));
        $this->registry['template']->show('account');
    }
    
    function logout() {
        $this->registry['model']->logVisit(28);
        $this->registry['model']->logout($_SESSION['user']->id);
        $this->registry['template']->show('logout');
    }
    
    function register() {
        $this->registry['model']->logVisit(16);
        $error =  $this->isCorrect();
        $this->registry['logger']->lwrite("action: ".$_POST['userAction']." user: ".$_POST['userName']);
        if ($error == ""){
            $_SESSION['user']->name = htmlspecialchars(trim($_POST['userName']));
            $_SESSION['user']->email = htmlspecialchars(trim($_POST['userEmail']));
            if (isset($_POST['userPhone']))
                $_SESSION['user']->phone = $_POST['userPhone'];
            if (isset($_POST['userPassword']) && $_POST['userPassword'] != "") {
                $_SESSION['user']->password = $_POST['userPassword'];
            }
        /*    if ($_POST['isClient'] == "true"){
                $this->registry->set('isClient', '1');
            }else{
                $this->registry->set('isClient', '0');
            }*/
            if ($_POST['isSpam'] == "true"){
                $_SESSION['user']->spam = 1;
            }else{
                $_SESSION['user']->spam = 0;
            }
            if ($_POST['userAction'] != "login")
                $this->registry['model']->updateUser();
            else 
                $this->registry['model']->login();
        } else {
            $error = "<div id='error'>" . $error . "</div>";
        }
        $this->registry['logger']->lwrite($error);
        echo $error;
    }
    
    private function isCorrect() {
        $action = $_POST['userAction'];
        $error = "";
        //First of all we check user name for register and update actions. It shouldn't be empty
        if ($action != 'login' && trim($_POST['userName']) == "") 
            $error = $error . "Пустое имя пользователя<br>";
        //Then we check user email. It should not be empty for all actions
	if (trim($_POST['userEmail']) == "") {
            $error = $error .  "Пустая почта<br>"; 
        } else {
            //Also the email should match pattern
            if (!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', trim($_POST['userEmail']))) 
                    $error = $error . "Подозрительная почта<br>";
            else
                //For update and register we also check that this email doesn't exist in DB
                if ($action != 'login' && $_SESSION['user']->email != $_POST['userEmail'] && $this->registry['model']->checkEmailExists($_POST['userEmail'])) 
                    $error = $error .  "Эта почта уже зарегистрирована<br>";
        }
        //Then we check password. For all actions it shouldn't be empty    
	if ($_POST['userPassword'] == "") 
            $error = $error .  "Пустой пароль<br>";
        //For update and register the password should be equal with confirmation
        if ($action != 'login' && $_POST['userPassword'] != $_POST['userConfirm']) 
            $error = $error .  "Пароли не совпадают<br>"; 
        //For login we also check that such user exists in DB
	if ($action == 'login' && $error == '' && !$this->registry['model']->checkUser($_POST['userEmail'], $_POST['userPassword'])) 
                $error = $error . "Неправильная почта или пароль<br>";
        return $error; 
    }
}

