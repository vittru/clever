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
    
    function certs() {
        if (isset($_GET['firm'])) {
            $firmId = $_GET['firm'];
            $this->registry['model']->logVisit(31, $firmId);
            $this->registry['template']->set('showFirm', $this->registry['firms'][$firmId]);
        } else {
            $this->registry['model']->logVisit(31);
            $this->registry['template']->set('firms', $this->registry['firms']);
        }    
        $this->registry['template']->show('certs');
    }
    
}

