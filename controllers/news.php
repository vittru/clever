<?php

Class Controller_News Extends Controller_Base {
        
    function index() {
        $this->registry['model']->logVisit(7);
        $this->registry['model']->getNews();
        $this->registry['template']->set('news', $this->registry['news']);
        $this->registry['template']->show('news');
    }
}

