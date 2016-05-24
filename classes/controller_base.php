<?php


Abstract Class Controller_Base {

        protected $registry;

        function __construct($registry) {
            $this->registry = $registry;
            $this->registry['template']->set ('userName', $this->registry['userName']);
            $this->registry['template']->set ('lastVisit', $this->registry['lastVisit']);
            $this->registry['template']->set ('userEmail', $this->registry['userEmail']);
            $this->registry['template']->set ('isClient', $this->registry['isClient']);
            $this->registry['template']->set ('password', $this->registry['password']);
            $this->registry['template']->set ('spam', $this->registry['isSpam']);
        
        }

        abstract function index();
}


