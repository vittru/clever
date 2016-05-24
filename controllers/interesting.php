<?php

Class Controller_Interesting Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(11);
        $this->registry['template']->show('interesting');
    }

    function blogs() {
        $this->registry['model']->logVisit(12);
        $this->registry['template']->show('blogs');
    }
    
    function links() {
        $this->registry['model']->logVisit(13);
        $this->registry['template']->show('links');
    }
}





