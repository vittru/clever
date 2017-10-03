<?php

Class Controller_Subscribe Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(17);
        $error=$this->checkEmail($_POST['userEmail']);
        if ($error == "") {
            $_SESSION['user']->email = htmlspecialchars(trim($_POST['userEmail']));
            $_SESSION['user']->spam = 1;
            //$this->registry->set('isClient', '0');
            $_SESSION['user'] = $this->registry['model']->updateUser($_SESSION['user']);
        } else {
            $error = "<div id='error'>" . $error . "</div>";
        }
        echo $error;
    }
    
    function stop() {
        if (isset($_GET['id'])) {
            $profileId = $_GET['id'];
            if ($this->registry['model']->profileExists($profileId)) {
                $this->registry['model']->logVisit(36);
                $this->registry['model']->unsubscribe($profileId);
                $this->registry['template']->set('mainMessage', 'Вы успешно отписались от рассылки');
                $this->registry['template']->set('secondMessage', 'Больше мы не будем посылать вам наши акции и интересные предложения');
                $this->registry['template']->show('logout');
            }
            else
                $this->registry['template']->show('404');
        }
        else
            $this->registry['template']->show('404');
    }
}
