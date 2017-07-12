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
            $this->registry['template']->set('pageHeader', $firm->name);        
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
            $firmId = $this->registry['model']->getFirmIdByUrl($route);
            if ($firmId)
                $this->showFirm($firmId);
            else {
                $this->registry['model']->logVisit(3);
                $this->registry['template']->set('firms', $this->registry['firms']);
                $this->registry['template']->show('firm');
            }    
        }    
    }
    
    function type() {
        $typeId=$_GET['id'];
        if ($typeId) {
            $metaData = $this->registry['model']->getTypeMeta($typeId);
            $this->registry['template']->set('pageHeader', 'Товары ' . mb_strtolower($this->registry['types'][$typeId]));
            $this->registry['template']->set('catalogGoods', $this->registry['model']->getGoodsByType($typeId));
            $this->registry['template']->set('bestBefore', false);
            $this->registry['template']->set('hideFilterType', true);
            $this->registry['logger']->lwrite('Description: ' . $metaData['description']);
            $this->registry['template']->set('pageSubHeader', $metaData['description']);
            $this->registry['template']->set('metaTitle', $metaData['metaTitle']);
            $this->registry['template']->set('metaDescription', $metaData['metaDescription']);
            $this->registry['template']->set('metaKeywords', $metaData['metaKeywords']);
            $this->registry['template']->set('descAfter', $metaData['descAfter']);
            $this->registry['model']->logVisit(4, $typeId);
            $this->registry['template']->show('catalog');
        } else {
            $this->registry['template']->set('types', $this->registry['types']);
            $this->registry['model']->logVisit(4);
            $this->registry['template']->show('type');
        }    
    }

    function category() {
        $rt=explode('/', $_GET['route']);
        $route=$rt[(count($rt)-1)];
        $category = $this->registry['model']->getCategoryByUrl($route);
        if ($category) {
            $this->registry['model']->logVisit(5, $category->id);
            $this->registry['template']->set('catalogGoods', $this->registry['model']->getCategoryGoods($category->id));
            $this->registry['template']->set('pageHeader', $category->name);
            $this->registry['template']->set('pageSubHeader', $category->description);
            $this->registry['template']->set('bestBefore', false);
            $this->registry['template']->set('hideFilterCat', true);
            $this->registry['template']->show('catalog');
        } else {
            $this->registry['model']->logVisit(5);
            $this->registry['template']->set('categories', $this->registry['model']->getCategories());
            $this->registry['template']->show('category');
        }
    }
}


