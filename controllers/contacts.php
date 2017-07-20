<?php

Class Controller_Contacts Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(14);
        $this->registry['template']->set('metaTitle', 'Контакты интернет-магазина Клевер');
        $this->registry['template']->set('metaDescription', 'Контакты магазина Клевер.');
        $this->registry['template']->show('contacts');
    }
}



