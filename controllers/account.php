<?php

Class Controller_Account Extends Controller_Base {

    function index() {
        if ($_SESSION['user']->name) {
            $this->registry['model']->logVisit(27);
            if ($this->registry['isadmin'])
                $this->registry['template']->set('orders', $this->registry['model']->getAllOrders());
            else
                $this->registry['template']->set('orders', $this->registry['model']->getUserOrders($_SESSION['user']->id));
            $this->registry['template']->show('account');
        } else {
            $this->registry['template']->show('404');
        }    
    }
    
    function logout() {
        $this->registry['model']->logVisit(28);
        $this->registry['model']->logout($_SESSION['user']->id);
        $_SESSION['user']->name = '';
        $this->registry['template']->show('logout');
    }
    
    function register() {
        $this->registry['model']->logVisit(16);
        $error =  $this->isCorrect();
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
            if ($_POST['isSpam'] == "true") {
                $_SESSION['user']->spam = 1;
            } else {
                $_SESSION['user']->spam = 0;
            }
            if ($_POST['userAction'] != "login") {
                $_SESSION['user'] = $this->registry['model']->updateUser($_SESSION['user']);
                if (isset($_POST['userFlyer']) && $_POST['userAction'] == 'register') {
                    $this->registry['model']->applyFlyer($_SESSION['user']->id, $_POST['userFlyer']);
                }    
            } else 
                $_SESSION['user'] = $this->registry['model']->login($_SESSION['user']);
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
        if (isset($_POST['userFlyer']) && $action == 'register' && $this->registry['model']->flyerUsed($_POST['userFlyer']))
            $error = $error . "Этот сертификат уже использован<br>";
        return $error; 
    }
    
    function orders() {
        $this->registry['model']->logVisit(29);
        if (isset($_GET['id'])) {
            $order = $this->registry['model']->getOrder($_GET['id']);
            $this->registry['template']->set('order', $order);
        }
        $this->registry['template']->show('orders');
    }
    
    function updateorder() {
        if ($this->registry['isadmin']) {
            $status = $_GET['status'];
            $orderid = $_GET['order'];
            $this->registry['model']->updateOrder($orderid, $status);
            $order = $this->registry['model']->getOrder($orderid);
            $to      = $order->email;
            $subject = 'Clever. Статус заказа №' . $orderid . ' изменен';
            $message = '<html><body><h2>Заказ №' . $orderid . '</h2>'
                    . '<p>Статус вашего заказа изменен.</p>' .
                    '<p><b>Статус:</b> ' . $order->status . '</p>' . 
                    '<p>' . $order->statusdesc . '</p>' . 
                    '<p>Отследить заказ Вы также можете на <a href="www.clubclever.ru/account/orders?id='. $orderid . '">нашем сайте</a></p>' .
                    '<p>Больше информации о наших акциях и товарах:</p>'.
                    '<ul><li><a href="www.clubclever.ru">www.cluclever.ru</a></li>' .
                    '<li><a href="https://vk.com/clubcleverru">http://vk.com/clubcleverru</a></li>' . 
                    '<li><a href="http://www.instagram.com/clubclever.ru/">http://www.instagram.com/clubclever.ru</a></li></body></html>';;
            $this->sendMail($to, $subject, $message);
        } else
            $this->registry['template']->show('404');
    }
}

