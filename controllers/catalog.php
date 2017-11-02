<?php

Class Controller_Catalog Extends Controller_Base {

    function index() {
        //$this->registry['model']->logVisit(2);
        $this->registry['template']->show('404');
    }

    private function showFirm($firmId) {
        $this->registry['model']->logVisit(3, $firmId);
        $firm = $this->registry['model']->getFirm($firmId);
        if ($firm) {
            if ($firm->h1)
                $header = $firm->h1;
            else
                $header = $firm->name;
            $this->registry['template']->set('pageHeader', $header);        
            $this->registry['template']->set('pageSubHeader', $firm->description);
            $this->registry['template']->set('catalogGoods', $firm->goods);
            $this->registry['template']->set('metaTitle', $firm->metaTitle);
            $this->registry['template']->set('metaDescription', $firm->metaDescription);
            $this->registry['template']->set('metaKeywords', $firm->metaKeywords);
            $this->registry['template']->set('descAfter', $firm->descAfter);
            $this->registry['template']->set('bestBefore', false);
            $this->registry['template']->set('hideFilterFirm', true);
            $this->registry['template']->show('catalog');
        } else {
            $this->registry['template']->set('firms', $this->registry['firms']);
            $this->registry['template']->show('firm');
        }    
    }
    
    function firm() {
        if (isset($_GET['id'])) {
            $this->showFirm($_GET['id']);
        } else {          
            $rt=explode('/', $_GET['route']);
            $route=$rt[(count($rt)-1)];
            $firmId = $this->registry['model']->getObjectIdByUrl('firms', $route);
            if ($firmId)
                $this->showFirm($firmId);
            else {
                $this->registry['model']->logVisit(3);
                $this->registry['template']->set('objects' , $this->registry['firms']);
                $this->registry['template']->set('otype' , 'firm');
                $this->registry['template']->set('pageHeader' , 'Наши бренды');
                $this->registry['template']->set('pageSubHeader' , 'Мы торгуем только товарами проверенных годами фирм');
                $this->registry['template']->set('metaTitle', 'Бренды натуральной косметики — интернет-магазин экологической косметики');
                $this->registry['template']->set('metaDescription', 'Популярные производители эко косметики.');
                $this->registry['template']->show('catalog_top');
            }    
        }    
    }
    
    private function showType($typeId) {
        $metaData = $this->registry['model']->getTypeMeta($typeId);
        $this->registry['template']->set('pageHeader', 'Товары ' . mb_strtolower($this->registry['types'][$typeId]->name));
        $this->registry['template']->set('catalogGoods', $this->registry['model']->getGoodsByType($typeId));
        $this->registry['template']->set('bestBefore', false);
        $this->registry['template']->set('hideFilterType', true);
        $this->registry['template']->set('pageSubHeader', $metaData['description']);
        $this->registry['template']->set('metaTitle', $metaData['metaTitle']);
        $this->registry['template']->set('metaDescription', $metaData['metaDescription']);
        $this->registry['template']->set('metaKeywords', $metaData['metaKeywords']);
        $this->registry['template']->set('descAfter', $metaData['descAfter']);
        $this->registry['model']->logVisit(4, $typeId);
        $this->registry['template']->show('catalog');
    }
    
    function type() {
        if (isset($_GET['id']))
            $this->showType ($_GET['id']);
        else {
            $rt=explode('/', $_GET['route']);
            $route=$rt[(count($rt)-1)];
            $typeId = $this->registry['model']->getObjectIdByUrl('types', $route);
            if ($typeId)
                $this->showType($typeId);
            else {
                $this->registry['template']->set('types', $this->registry['types']);
                $this->registry['template']->set('metaTitle', 'Экологическая косметика для взрослых и детей — интернет магазин Клевер');
                $this->registry['template']->set('metaDescription', 'Каталог эко коcметики');
                $this->registry['model']->logVisit(4);
                $this->registry['template']->show('type');
            }    
        }    
    }

    function category() {
        $rt=explode('/', $_GET['route']);
        $route=$rt[(count($rt)-1)];
        $category = $this->registry['model']->getCategory($this->registry['model']->getObjectIdByUrl('categories', $route));
        if ($category) {
            $this->registry['model']->logVisit(5, $category->id);
            $this->registry['template']->set('catalogGoods', $this->registry['model']->getCategoryGoods($category->id));
            $this->registry['template']->set('pageHeader', $category->name);
            $this->registry['template']->set('pageSubHeader', $category->description);
            $this->registry['template']->set('metaTitle', $category->metaTitle);
            $this->registry['template']->set('metaDescription', $category->metaDescription);
            $this->registry['template']->set('bestBefore', false);
            $this->registry['template']->set('hideFilterCat', true);
            $this->registry['template']->show('catalog');
        } else {
            $this->registry['model']->logVisit(5);
            $this->registry['template']->set('objects' , $this->registry['model']->getCategories());
            $this->registry['template']->set('otype' , 'category');
            $this->registry['template']->set('pageHeader' , 'Категории товаров');
            $this->registry['template']->set('pageSubHeader' , 'Мы постоянно стараемся расширить наш ассортимент');
            $this->registry['template']->show('catalog_top');
        }
    }

    function sc() {
        $rt=explode('/', $_GET['route']);
        $route=$rt[(count($rt)-1)];
        $scId = $this->registry['model']->getObjectIdByUrl('supercats', $route);
        if ($scId) {
            $this->registry['model']->logVisit(6, $scId);
//            $this->registry['template']->set('catalogGoods', $this->registry['model']->getCategoryGoods($category->id));
//            $this->registry['template']->set('pageHeader', $category->name);
//            $this->registry['template']->set('pageSubHeader', $category->description);
//            $this->registry['template']->set('metaTitle', $category->metaTitle);
//            $this->registry['template']->set('metaDescription', $category->metaDescription);
            $this->registry['template']->set('bestBefore', false);
            $this->registry['template']->set('hideFilterCat', true);
            $this->registry['template']->show('catalog');
        } else {
            $this->registry['model']->logVisit(6);
            $this->registry['template']->set('objects' , $this->registry['model']->getSuperCats());
            $this->registry['template']->set('otype' , 'sc');
            $this->registry['template']->set('pageHeader' , 'Каталог товаров');
            $this->registry['template']->set('pageSubHeader' , 'В нашем каталоге Вы найдете товары на любой вкус.');
            $this->registry['template']->show('catalog_top');
        }
    }

        }


