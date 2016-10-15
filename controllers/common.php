<?php

Class Controller_Common Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(11);
        $this->registry['template']->show('404');
    }

    function delivery() {
        $this->registry['model']->logVisit(12);
        $this->registry['template']->show('delivery');
    }

    function payment() {
        $this->registry['model']->logVisit(13);
        $this->registry['template']->show('payment');
    }
    
    function moneyback() {
        $this->registry['model']->logVisit(15);
        $this->registry['template']->show('moneyback');
    }

    function offer() {
        $this->registry['model']->logVisit(8);
        $this->registry['template']->show('offer');
    }
    
}

