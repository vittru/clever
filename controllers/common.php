<?php

Class Controller_Common Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(11);
        $this->registry['template']->show('404');
    }

    function delivery() {
        $this->registry['template']->set('metaTitle', 'Доставка в магазине Клевер');
        $this->registry['template']->set('metaDescription', 'Доставка в интернет-магазине Клевер в Самаре и Самарской области осуществляется в течение 1-3 дней с момента подтверждения полной комплектации заказа с 9:00 до 24:00.');
        $this->registry['model']->logVisit(12);
        $this->registry['template']->show('delivery');
    }

    function payment() {
        $this->registry['template']->set('metaTitle', 'Оплата в интернет-магазине Клевер');
        $this->registry['template']->set('metaDescription', 'Информация об оплате в интернет-магазине Клевер.');
        $this->registry['model']->logVisit(13);
        $this->registry['template']->show('payment');
    }
    
    function moneyback() {
        $this->registry['template']->set('metaTitle', 'Возврат товаров в интернет-магазине Клевер');
        $this->registry['template']->set('metaDescription', 'Информация о возврате товаров в интернет-магазине Клевер.');
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
    
    function bonus() {
        $this->registry['template']->set('metaTitle', 'Бонусы от магазина Клевер');
        $this->registry['template']->set('metaDescription', 'Информация о бонусах в магазине Клевер.');
        $this->registry['model']->logVisit(32);
        $this->registry['template']->show('bonus');
    }
    
    function blog() {
        if (isset($_GET['entry'])) {
            $entryId = $_GET['entry'];
            $entry = $this->registry['model']->getBlogEntry($entryId);
            if ($entry->name) {
                $this->registry['model']->logVisit(33, $entryId);
                $this->registry['template']->set('entry', $entry);
                $this->registry['template']->set('metaTitle', $entry->metaTitle);
                $this->registry['template']->set('metaDescription', $entry->metaDescription);
                $this->registry['template']->show('blog');
            } else {
                $this->registry['model']->logVisit(404, false, $_SERVER['QUERY_STRING']);
                $this->registry['template']->show('404');
            }    
        } else { 
            $this->registry['model']->logVisit(33);
            $this->registry['template']->set('entries', $this->registry['model']->getBlogEntries());
            $this->registry['template']->set('metaTitle', 'Статьи о косметическом уходе');
            $this->registry['template']->set('metaDescription', 'Полезные статьи об уходе');
            $this->registry['template']->show('blog');
        }    
    }
}