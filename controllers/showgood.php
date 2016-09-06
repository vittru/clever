<?php

Class Controller_Showgood Extends Controller_Base {
        
    function index() {
        foreach($this->registry['goods'] as $id=>$good) {
            if ($id == $_GET['id']) {
                $this->registry['template']->set('good', $good);
                break;
            }    
        }
        $this->registry['template']->set('hasProblems', $good->hasProblems());
        $this->registry['template']->set('hasEffects', $good->hasEffects());
        $this->registry['template']->set('hasSkintypes', $good->hasSkintypes());
        $this->registry['template']->set('hasHairtypes', $good->hasHairtypes());
        //$this->registry->set('good', $this->registry['model']->getGood($_GET['id']));
        $this->registry['template']->show('showgood');
    }
}    

