<?php

Class Controller_Showgood Extends Controller_Base {
        
    function index() {
        $this->registry->set('good', $this->registry['model']->getGood($_GET['id']));
        $this->registry['template']->show('showgood');
    }
}    

