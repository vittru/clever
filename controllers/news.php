<?php

Class Controller_News Extends Controller_Base {
        
    function index() {
        $this->registry['model']->logVisit(7);
        $this->registry['template']->set('news', $this->registry['model']->getNews(0));
        $this->registry['template']->set('metaTitle', 'Новости — экомаркет Клевер');
        $this->registry['template']->set('metaDescription', 'Новости о предложениях и акциях компании Клевер.');
        $this->registry['template']->show('news');
    }
}

