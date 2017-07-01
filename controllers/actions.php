<?php

Class Controller_Actions Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(19);
        $this->registry['template']->show('actions');
    }
    
    function karolina2016() {
        $this->registry['model']->logVisit(19);
        $this->registry['template']->show('karolina2016');
    }
        
    function bestbefore() {
        $this->registry['model']->logVisit(34);
        $catalogGoods=array();
        foreach ($this->registry['model']->getAllGoods() as $goodId=>$good) {
            if ($good->hasBB() && $good->isAvailable()) {
                $catalogGoods[$goodId] = $good;
            }
        }
        $this->registry['template']->set('catalogGoods', $catalogGoods);
        $this->registry['template']->set('bestBefore', true);
        $this->registry['template']->set('pageHeader', 'Товары с истекающим сроком годности');
        $this->registry['template']->show('catalog');
        
    }

    function discounts() {
        $this->registry['model']->logVisit(35);
        $catalogGoods=array();
        foreach ($this->registry['model']->getAllGoods() as $goodId=>$good) {
            if ($good->sale && $good->isAvailable()) {
                $catalogGoods[$goodId] = $good;
            }
        }
        $this->registry['template']->set('catalogGoods', $catalogGoods);
        $this->registry['template']->set('bestBefore', false);
        $this->registry['template']->set('pageHeader', 'Товары со скидками');
        $this->registry['template']->show('catalog');
        
    }

}

