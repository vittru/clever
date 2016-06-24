<?php

Class Controller_Question Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(18);
        $error = $this->checkEmail($_POST['userEmail']);
        if (trim($_POST['question']) == '') {
            $error = $error . "Пустой вопрос<br>";
        };
        if ($error == "") {
            $this->registry->set('userEmail', htmlspecialchars(trim($_POST['userEmail'])));
            if (trim($_POST['userName']) != '') {
                $this->registry->set('userName', htmlspecialchars(trim($_POST['userName'])));
            }
            $this->registry['model']->updateUser();
        } else {
            $error = "<div id='error'>" . $error . "</div>";
        };
        echo $error;
    }
}


