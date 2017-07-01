<?php

Class Controller_Showgood Extends Controller_Base {
        
    function index() {
        if (isset($_GET['id'])) {
            $good = $this->registry['model']->getGood($_GET['id']);
            if (!$good) {
                $this->registry['template']->show('404');
            } else {   
                $this->showGood($good);
            }               
        } else {    
            $rt=explode('/', $_GET['route']);
            $route=$rt[(count($rt)-1)];
            $goodId = $this->registry['model']->getGoodIdByUrl($route);
            if (!$goodId)
                $this->registry['template']->show('404');
            else {
                $this->showGood($this->registry['model']->getGood($goodId));
            }    
        }
    }
    
    private function showGood($good) {
        $this->registry['model']->logVisit(30, $good->id);
        if (isset($_GET['pm']))
            $pm = true;
        else 
            $pm = false;
        $this->registry['template']->set('pm', $pm);
        if (isset($_GET['bb']))
            $bb = true;
        else 
            $bb = false;
        $this->registry['template']->set('bb', $bb);
        $this->registry['template']->set('showGood', $good);
        $this->registry['template']->set('hasProblems', $good->hasProblems());
        $this->registry['template']->set('hasEffects', $good->hasEffects());
        $this->registry['template']->set('hasSkintypes', $good->hasSkintypes());
        $this->registry['template']->set('hasHairtypes', $good->hasHairtypes());
        $this->registry['template']->show('showgood');        
    }
}    

