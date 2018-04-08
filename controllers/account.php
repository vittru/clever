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
        $this->registry['template']->set('mainMessage', 'Спасибо, что были с нами');
        $this->registry['template']->set('secondMessage', 'И ждем вас снова');
        $this->registry['template']->show('message');
    }
    
    private function updateSession() {
        $_SESSION['user']->name = htmlspecialchars(trim($_POST['userName']));
        $_SESSION['user']->email = htmlspecialchars(trim($_POST['userEmail']));
        if (isset($_POST['userPhone'])) {
            $_SESSION['user']->phone = $_POST['userPhone'];
        }
        if (isset($_POST['userPassword']) && $_POST['userPassword'] != "") {
            $_SESSION['user']->password = $_POST['userPassword'];
        }
        if ($_POST['isSpam'] == "true") {
            $_SESSION['user']->spam = 1;
        } else {
            $_SESSION['user']->spam = 0;
        }
    }
    
    function newpassword() {
        $this->registry['template']->set('mainMessage', 'Новый пароль выслан Вам на email');
        $this->registry['template']->set('secondMessage', 'Рекомендуем сменить его после первого захода');
        $this->registry['template']->show('message');
    }
    
    function register() {
        $this->registry['model']->logVisit(16);
        $error =  $this->isCorrect();
        $action = $_POST['userAction'];
        if ($error == ""){
            switch ($action) {
                case 'password':
                    $password = $this->registry['model']->updatePassword($_POST['userEmail']);
                    $message = '<html><body><h2>Новый пароль для Экомаркета "Клевер"</h2>' .
                            '<p>Вы запросили восстановление пароля на сайте <a href="www.ecomarketclever.ru">www.ecomarketclever.ru</a>.</p>' .
                            '<p>Ваш новый пароль: <b>' . $password . '</b></p>' .
                            '<p>Рекомендуем изменить его сразу после захода на сайт</p>' .
                            '<p>Если Вы не запрашивали восстановление пароля, пожалуйста напишите нам на <a href="mailto:clever@ecomarketclever.ru">clever@ecomarketclever.ru</a> или позвоните +7-846-252-39-11 </p>' .
                            '</body></html>';
                    $this->sendMail($_POST['userEmail'], 'Экомаркет Клевер - восстановление пароля', $message);
                    break;
                case 'login':
                    $this->updateSession();
                    $_SESSION['user'] = $this->registry['model']->login($_SESSION['user']);
                    break;
                case 'register':
                    $this->updateSession();
                    $_SESSION['user'] = $this->registry['model']->updateUser($_SESSION['user']);
                    if (isset($_POST['userFlyer'])) {
                        $this->registry['model']->applyFlyer($_SESSION['user']->id, $_POST['userFlyer']);
                    }    
                    break;
                case 'update':
                    $this->updateSession();
                    $_SESSION['user'] = $this->registry['model']->updateUser($_SESSION['user']);
                    break;
            }
        } else {
            $error = "<div id='error'>" . $error . "</div>";
        }
        $this->registry['logger']->lwrite($error);
        echo $error;
    }

    
    //For login action we just check that email and password aren't epmpty and the user exists
    private function isLoginCorrect() {
        $error = $this->checkEmail($_POST['userEmail']) . 
                $this->checkEmpty($_POST['userPassword'], 'Пустой пароль');
        if ($error == '' && !$this->registry['model']->checkUser($_POST['userEmail'], $_POST['userPassword'])) {
            $error = $error . 'Неправильная почта или пароль<br>';
        }
        return $error;
    }
    
    //For register action we check the following:
    // - name is not empty
    // - email is not empty and satisfies criteria
    // - password is not empty
    // - password and confirm are equal
    // - email is not registered
    // - flyer not used
    private function isRegisterCorrect() {
        $error = $this->checkEmpty($_POST['userName'], 'Пустое имя пользователя') . 
                $this->checkEmail($_POST['userEmail']) . 
                $this->checkEmpty($_POST['userPassword'], 'Пустой пароль');
        if ($_POST['userPassword'] != $_POST['userConfirm']) {
            $error = $error . "Пароли не совпадают<br>";
        }
        if ($error == '' && $this->registry['model']->checkEmailExists($_POST['userEmail'])) {
            $error = $error . 'Эта почта уже зарегистрирована<br>';
        }
        if (isset($_POST['userFlyer']) && $this->registry['model']->flyerUsed($_POST['userFlyer'])) {
            $error = $error . "Этот сертификат уже использован<br>";
        }
        return $error;
    }
    
    //For update action we check almost the same as for register
    //The only difference is check for email existance
    private function isUpdateCorrect() {
        $error = $this->checkEmpty($_POST['userName'], 'Пустое имя пользователя') . 
                $this->checkEmail($_POST['userEmail']) . 
                $this->checkEmpty($_POST['userPassword'], 'Пустой пароль');
        if ($_POST['userPassword'] != $_POST['userConfirm']) {
            $error = $error . "Пароли не совпадают<br>";
        }
        if ($error == '' &&  $_SESSION['user']->email != $_POST['userEmail'] && $this->registry['model']->checkEmailExists($_POST['userEmail'])) {
            $error = $error . 'Эта почта уже зарегистрирована<br>';
        }
        return $error;
    }
    
    private function isPasswordCorrect() {
        $error = $this->checkEmail($_POST['userEmail']);
        if ($error == '' && !$this->registry['model']->checkEmailExists($_POST['userEmail'])) {
            $error = $error . 'Неправильная почта<br>';
        }
        return $error;
    }
    
    private function isCorrect() {
        $action = $_POST['userAction'];
        switch ($action) {
            case 'login':
                return $this->isLoginCorrect();
            case 'register':
                return $this->isRegisterCorrect();
            case 'update':
                return $this->isUpdateCorrect();
            case 'password':
                return $this->isPasswordCorrect();
            default:
                return 'Внутренняя ошибка';
        }
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
            $to = $order->email;
            $subject = 'Clever. Статус заказа №' . $orderid . ' изменен';
            $message = '<html><body><h2>Заказ №' . $orderid . '</h2>'
                    . '<p>Статус вашего заказа изменен.</p>' .
                    '<p><b>Статус:</b> ' . $order->status . '</p>' .
                    '<p>' . $order->statusdesc . '</p>' .
                    '<p>Отследить заказ Вы также можете на <a href="www.ecomarketclever.ru/account/orders?id=' . $orderid . '">нашем сайте</a></p>' .
                    '<p>Больше информации о наших акциях и товарах:</p>' .
                    '<ul><li><a href="www.ecomarketclever.ru">www.ecomarketclever.ru</a></li>' .
                    '<li><a href="https://vk.com/clubcleverru">http://vk.com/clubcleverru</a></li>' .
                    '<li><a href="http://www.instagram.com/clubclever.ru/">http://www.instagram.com/clubclever.ru</a></li></body></html>';
            $this->sendMail($to, $subject, $message);
        } else {
            $this->registry['template']->show('404');
        }
    }
}

