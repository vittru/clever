<?php

Class Controller_404 Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(404);
        $this->registry['template']->show('404');
    }   
}

