<?php

Class Controller_About Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(2);
        $this->registry['template']->show('about');
    }

    function director() {
        $this->registry['model']->logVisit(3);
        $this->registry['template']->show('director');
    }
    
    function club() {
        $this->registry['model']->logVisit(5);
        $this->registry['template']->show('club');;
    }
    
    function photo() {
        $this->registry['model']->logVisit(6);
        $this->registry['template']->show('photo');;
    }
    
    function teachers() {
        $this->registry['model']->logVisit(4);
        $this->registry['template']->show('teachers');;
    }
}




