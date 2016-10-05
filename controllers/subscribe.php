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
}
