<?php

Class Controller_Catalog Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(2);
        $this->registry['template']->show('catalog');
    }

    function firm() {
        $this->registry['model']->logVisit(3);
        $this->registry['template']->show('firm');
    }
    
    function type() {
        $this->registry['model']->logVisit(4);
        $this->registry['template']->show('type');
    }    
}


