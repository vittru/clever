<?php


Abstract Class Controller_Base {

    protected $registry;

    function __construct($registry) {
        $this->registry = $registry;
        $this->registry['template']->set('user', $this->registry['user'], true);
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


