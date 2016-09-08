<?php

Class Controller_Actions Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(19);
        $this->registry['template']->show('actions');
    }
}

