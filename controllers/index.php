<?php

Class Controller_Index Extends Controller_Base {
        
    function index() {
        $this->registry['model']->logVisit(1);
        $this->registry['template']->set('firms', $this->registry['firms']);
        $pgoods = $this->registry['model']->getPopularGoods();
        $this->registry['template']->set('pgoods', $pgoods);
        $this->registry['template']->set('metaTitle', 'Купить натуральную косметику в Самаре | Экамаркет Клевер');
        $this->registry['template']->set('metaDescription', 'Купить натуральную органическую косметику в Самаре по низкой цене и с доставкой по городу в интернет-магазине Клевер.');
        $this->registry['template']->set('metaKeywords', 'интернет магазин, купить, натуральная косметика, органик, официальный сайт, органическая косметика, эко косметика, экомаркет, самара');
        $this->registry['template']->show('index');
    }
}