<?php

Class Controller_Index Extends Controller_Base {
        
    function index() {
        $this->registry['model']->logVisit(1);
        $this->registry['template']->set('firms', $this->registry['firms']);
        $pgoods = array();
        for ($i = 1; $i < 5; $i++){
            $pgoods[$i] = $this->registry['model']->getPopularGoods($i);
        }    
        $this->registry['template']->set('pgoods', $pgoods);
        $this->registry['template']->set('metaTitle', 'Интернет-магазин натуральной эко косметики в Самаре | Купить органическую косметику | экомаркет Клевер');
        $this->registry['template']->set('metaDescription', 'Купить натуральную органическую косметику в Самаре по низкой цене и с доставкой по городу в интернет-магазине Клевер.');
        $this->registry['template']->set('metaKeywords', 'интернет магазин, купить, натуральная косметика, органик, официальный сайт, органическая косметика, эко косметика, экомаркет, самара');
        $this->registry['template']->show('index');
    }
}


