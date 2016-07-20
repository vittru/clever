<?php

Class Controller_Showgood Extends Controller_Base {
        
    function index() {
        foreach($this->registry['goods'] as $id=>$good) {
            if ($id == $_GET['id']) {
                $this->registry->set('good', $good);
                break;
            }    
        }
        //$this->registry->set('good', $this->registry['model']->getGood($_GET['id']));
        $this->registry['template']->show('showgood');
    }
}    

