<?php


Abstract Class Controller_Base {

    protected $registry;

    function __construct($registry) {
        $this->registry = $registry;
        $this->registry['template']->set ('userName', $this->registry['userName']);
        $this->registry['template']->set ('lastVisit', $this->registry['lastVisit']);
        $this->registry['template']->set ('userEmail', $this->registry['userEmail']);
    //    $this->registry['template']->set ('isClient', $this->registry['isClient']);
        $this->registry['template']->set ('password', $this->registry['password']);
        $this->registry['template']->set ('spam', $this->registry['isSpam']);

    }

    abstract function index();
        
    function checkEmail($email) {
        $error="";
        if (trim($email) == "") {
            $error = $error .  "Пустая почта<br>"; 
        } else {
            if (!preg_match('/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/is', trim($email))) $error = $error . "Ваша почта кажется нам подозрительной<br>";
        }
        return $error;
    }
}


