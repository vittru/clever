<?php

Class Controller_Showgood Extends Controller_Base {
        
    function index() {
        if (!isset($_GET['id'])) {
            $this->registry['template']->show('404');
        } else {
            $good = $this->registry['goods'][$_GET['id']];
            if (isset($_GET['pm']))
                $pm = true;
            else 
                $pm = false;
            $this->registry['template']->set('pm', $pm);
            $this->registry['template']->set('showGood', $good);
            $this->registry['template']->set('hasProblems', $good->hasProblems());
            $this->registry['template']->set('hasEffects', $good->hasEffects());
            $this->registry['template']->set('hasSkintypes', $good->hasSkintypes());
            $this->registry['template']->set('hasHairtypes', $good->hasHairtypes());
            $this->registry['template']->show('showgood');
        }    
    }
}    

