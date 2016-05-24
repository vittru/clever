<?php

Class Controller_Courses Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(8);
        $this->registry['template']->show('courses');
    }

    function schedule() {
        $this->registry['model']->logVisit(9);
        $this->registry['template']->show('schedule');
    }
    
    function buy() {
        $this->registry['model']->logVisit(10);
        $this->registry['template']->show('buy');
    }
    
}




