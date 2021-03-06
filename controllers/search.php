<?php

Class Controller_Search Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(10, false , $_SERVER['QUERY_STRING']);
        $this->registry['template']->set('pageHeader', 'Вы искали');
        
        $pageSubHeader = '<table class="table search-table">';
        foreach($_GET as $key => $value){
            if (!empty($value) and $key!="route") {
                switch ($key) {
                    case "type":
                        $pageSubHeader .= "<tr><td></td><td class=\"bold\">Товары ".mb_strtolower($this->registry['types'][$value]->name)."</td></tr>";
                        $this->registry['template']->set('search_type', $value);
                        break;
                    case "name":
                        $pageSubHeader .= "<tr><td>Название:</td><td class=\"bold\">".$value."</td></tr>";
                        $this->registry['template']->set('search_text', $value);
                        break;
                    case "supercat":
                        foreach($this->registry['supercats'] as $sc) {
                            if ($sc->id == $value) {
                                $pageSubHeader .= "<tr><td>Тип:</td><td class=\"bold\">".$sc->name."</td></tr>";
                                $this->registry['template']->set('search_supercat', $value);
                            }    
                        }
                        break;
                    case "effect":
                        $pageSubHeader .= "<tr><td>Эффект:</td><td class=\"bold\">".$this->registry['effects'][$value]."</td></tr>";
                        $this->registry['template']->set('search_effect', $value);
                        break;
                    case "hairtype":
                        $pageSubHeader .= "<tr><td>Тип волос:</td><td class=\"bold\">".$this->registry['hairtypes'][$value]."</td></tr>";
                        $this->registry['template']->set('search_hairType', $value);
                        break;
                    case "skintype":
                        $pageSubHeader .= "<tr><td>Тип кожи:</td><td class=\"bold\">".$this->registry['skintypes'][$value]."</td></tr>";
                        $this->registry['template']->set('search_skinType', $value);
                        break;
                    case "firm":    
                        $pageSubHeader .= "<tr><td>Бренд:</td><td class=\"bold\">".$this->registry['firms'][$value]->name."</td></tr>";
                        $this->registry['template']->set('search_firm', $value);
                        break;
                    case "problem":    
                        $pageSubHeader .= "<tr><td>Проблема:</td><td class=\"bold\">".$this->registry['problems'][$value]."</td></tr>";
                        $this->registry['template']->set('search_problem', $value);
                        break;
                    case "description":
                        $pageSubHeader .= "<tr><td>Описание:</td><td class=\"bold\">".$value."</td></tr>";
                        $this->registry['template']->set('search_desc', $value);
                        break;                        
                    case "howTo":
                        $pageSubHeader .= "<tr><td>Способ применения:</td><td class=\"bold\">".$value."</td></tr>";
                        $this->registry['template']->set('search_howTo', $value);
                        break;
                    case "madeOf":
                        $pageSubHeader .= "<tr><td>Состав:</td><td class=\"bold\">".$value."</td></tr>";
                        $this->registry['template']->set('search_madeOf', $value);
                        break;
                    case "category":
                        $pageSubHeader .= "<tr><td>Категория:</td><td class=\"bold\">".$this->registry['categories'][$value]."</td></tr>";
                        $this->registry['template']->set('search_category', $value);
                        break;
                }
            }
        }
        $pageSubHeader .= '<tr><td colspan="2"></td></tr></table>';
        $catalogGoods = $this->performSearch($_GET);
        $this->registry['template']->set('pageSubHeader', $pageSubHeader);
        $this->registry['template']->set('pageSecondHeader', 'Мы нашли товаров: ' . count($catalogGoods));
        $this->registry['template']->set('bestBefore', false);
        $this->registry['template']->set('catalogGoods', $catalogGoods);
        $this->registry['template']->show('catalog');
    }
    
    private function performSearch($criteria) {
        $foundgoods=array();
        foreach($criteria as $key => $value) {
            if ($key == "name" and !empty($value)) {
                $foundgoods = $this->registry['model']->searchGoods('name', $value);
                $keywords = preg_split('/[\s]+/', $value);
                if (sizeof($keywords) > 1) {
                    foreach ($keywords as $key => $keyword){
                        if ($keyword and $keyword != 'и' and $keyword != 'для') {
                            $addGoods = $this->registry['model']->searchGoods('name', $keyword);
                        }    
                        $foundgoods = $foundgoods + $addGoods;
                    }
                }
                //Search by brand (we perform it only for whole srting)
                foreach ($this->registry['firms'] as $firmId => $firm) {
                    if (mb_stripos($firm->name, $value) !== false) {
                        $firmGoods = $this->registry['model']->getGoodsByFirm($firmId);
                        $foundgoods = $foundgoods + $firmGoods;
                    }
                }
            }
        }
        /*
        foreach ($this->registry['model']->getAllGoods() as $goodId=>$good) {
            $found = true;
            foreach($criteria as $key => $value){
                if (!empty($value) and $key!="route") {
                    switch ($key) {
                        case "name":
                            if (mb_stripos(str_replace('&nbsp;', ' ', $good->name), $value)===false)
                                $found = false;
                            break;
                        case "type":
                            $found = false;
                            foreach($good->types as $id=>$type) {
                                if ($id == $value)
                                    $found = true;
                            }
                            break;
                        case "effect":
                            if (!in_array($value, $good->effs))
                                $found = false;
                            break;
                        case "supercat":
                            $found = false;
                            foreach($good->supercats as $id=>$type) {
                                if ($id == $value)
                                    $found = true;
                            }
                            break;
                        case "hairtype":
                            if (!in_array($value, $good->hairtypes))
                                $found = false;
                            break;
                        case "skintype":
                            if (!in_array($value, $good->skintypes))
                                $found = false;
                            break;
                        case "firm":    
                            if ($value!==$good->firmId)
                                $found = false;
                            break;
                        case "problem":    
                            if (!in_array($value, $good->problems))
                                $found = false;
                            break;
                        case "description":
                            if (mb_stripos(str_replace('&nbsp;', ' ', $good->description), $value)===false and mb_stripos($good->shortdesc, $value)===false)
                                $found = false;
                            break;                        
                        case "howTo":
                            if (mb_stripos(str_replace('&nbsp;', ' ', $good->howTo), $value)===false)
                                $found = false;
                            break;
                        case "madeOf":
                            if (mb_stripos(str_replace('&nbsp;', ' ', $good->madeOf), $value)===false)
                                $found = false;
                            break;
                        case "category":
                            if (!in_array($value, $good->cats))
                                $found = false;
                            break;
                    }
                }
                if (!$found) {
                    break;
                }    
            }
            if ($found and !$good->hidden) {
                $foundgoods[$goodId] = $good;
            }
        } */
        return $foundgoods;
    }

}
