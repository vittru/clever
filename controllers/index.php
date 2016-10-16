<?php

Class Controller_Index Extends Controller_Base {
        
    function index() {
        $this->registry['model']->logVisit(1);
        $this->registry['template']->set('firms', $this->registry['firms']);
        $pgoods = array();
        for ($i = 1; $i < 5; $i++){
            $pgoods[$i] = $this->registry['model']->getPopularGoods($i);
        }    
        $this->registry['template']->set('pgoods', $pgoods);
        $this->registry['template']->show('index');
    }
}


