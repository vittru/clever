<?php

Class Controller_About Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(9);
        $this->registry['template']->show('about');
    }
}