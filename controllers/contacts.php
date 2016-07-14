<?php

Class Controller_Contacts Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(14);
        $this->registry['template']->show('contacts');
    }
}



