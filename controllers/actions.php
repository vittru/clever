<?php

Class Controller_Actions Extends Controller_Base {

    function index() {
        $this->registry['template']->show('404');
    }
    
    function karolina2016() {
        $this->registry['model']->logVisit(19);
        $this->registry['template']->show('karolina2016');
    }
}

