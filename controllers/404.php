<?php

Class Controller_404 Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(404, false, $_SERVER['QUERY_STRING']);
        $this->registry['template']->show('404');
    }   
}

