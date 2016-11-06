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
            $_SESSION['user'] = $this->registry['model']->updateUser($_SESSION['user']);
            $this->registry['model']->addQuestion($_SESSION['user']->id, $_POST['question']);
            $this->sendQuestion($_POST['userEmail'], $_POST['userName'], $_POST['question']);
        } else {
            $error = "<div id='error'>" . $error . "</div>";
        };
        echo $error;
    }
    
    private function sendQuestion($email, $name, $question) {
        $to      = $this->registry['mainemail'];
        $subject = "Новый вопрос на сайте";
        $message = "<html><body><h2>На сайте задан новый вопрос</h2>" .
                "<p><b>Пользователь:</b> " . $name . "</p>" . 
                "<p><b>Email:</b> " . $email . "</p>" . 
                "<p><b>Вопрос:</b> " . $question . "</p></body></html>";
        $this->registry['logger']->lwrite($message);
        $this->sendMail($to, $subject, $message);        
    }
}


