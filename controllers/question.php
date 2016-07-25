<?php

Class Controller_Question Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(18);
        $error = $this->checkEmail($_POST['userEmail']);
        if (trim($_POST['question']) == '') {
            $error = $error . "Пустой вопрос<br>";
        };
        if ($error == "") {
            $_SESSION['user']->email = htmlspecialchars(trim($_POST['userEmail']));
            if (trim($_POST['userName']) != '') {
                $_SESSION['user']->name = htmlspecialchars(trim($_POST['userName']));
            }
            $this->registry['model']->updateUser();
            $this->registry['model']->addQuestion($_SESSION['user']->id, $_POST['question']);
        } else {
            $error = "<div id='error'>" . $error . "</div>";
        };
        echo $error;
    }
}


