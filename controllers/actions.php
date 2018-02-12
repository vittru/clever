<?php

Class Controller_Actions Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(19);
        $this->registry['template']->set('metaTitle', 'Акции экомаркета Клевер');
        $this->registry['template']->set('metaDescription', 'Выгодные предложения от магазина эко косметики Клевер.');
        $this->registry['template']->set('news', $this->registry['model']->getNews(1));
        $this->registry['template']->show('actions');
    }
    
    function bestbefore() {
        $this->registry['model']->logVisit(34);
        $catalogGoods=array();
        foreach ($this->registry['model']->getAllGoods() as $goodId=>$good) {
            if ($good->hasBB()) {
                $catalogGoods[$goodId] = $good;
            }
        }
        $breadcrumbs['Акции'] = '/actions';
        $breadcrumbs['Истекающие сроки'] = NULL;
        $this->registry['template']->set('breadcrumbs', $breadcrumbs);
        $this->registry['template']->set('catalogGoods', $catalogGoods);
        $this->registry['template']->set('bestBefore', true);
        $this->registry['template']->set('pageHeader', 'Товары с истекающим сроком годности');
        $this->registry['template']->set('metaTitle', 'Скидки на эко товары с истекающим сроком годности');
        $this->registry['template']->set('metaDescription', 'Натуральную косметику можно купить с хорошей скидкой в интернет-магазине Клевер.');
        $this->registry['template']->show('catalog');
        
    }

    function discounts() {
        $this->registry['model']->logVisit(35);
        $catalogGoods=array();
        foreach ($this->registry['model']->getAllGoods() as $goodId=>$good) {
            //We don't show presents and sets in discounts
            if ($good->sale && $good->isAvailable() && !in_array(21, $good->cats) && !in_array(34, $good->cats)) {
                $catalogGoods[$goodId] = $good;
            }
        }
        $breadcrumbs['Акции'] = '/actions';
        $breadcrumbs['Скидки'] = NULL;
        $this->registry['template']->set('breadcrumbs', $breadcrumbs);
        $this->registry['template']->set('catalogGoods', $catalogGoods);
        $this->registry['template']->set('bestBefore', false);
        $this->registry['template']->set('pageHeader', 'Товары со скидками');
        $this->registry['template']->show('catalog');
        
    }

}

