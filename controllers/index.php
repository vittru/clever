<?php

Class Controller_Index Extends Controller_Base {
        
    function index() {
        $this->registry['model']->logVisit(1);
        $this->registry['template']->show('index');
    }
}


