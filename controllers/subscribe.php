<?php

Class Controller_Subscribe Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(17);
        $error=$this->checkEmail($_POST['userEmail']);
        if ($error == "") {
            $this->registry->set('userEmail', htmlspecialchars(trim($_POST['userEmail'])));
            $this->registry->set('isSpam', '1');
            $this->registry->set('isClient', '0');
            $this->registry['model']->updateUser();
        } else {
            $error = "<div id='error'>" . $error . "</div>";
        }
        echo $error;
    }
}
