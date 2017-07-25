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
                        break;
                    case "name":
                        $pageSubHeader .= "<tr><td>Название:</td><td class=\"bold\">".$value."</td></tr>";
                        break;
                    case "supercat":
                        $pageSubHeader .= "<tr><td>Тип:</td><td class=\"bold\">".$this->registry['supercats'][$value]."</td></tr>";
                        break;
                    case "effect":
                        $pageSubHeader .= "<tr><td>Эффект:</td><td class=\"bold\">".$this->registry['effects'][$value]."</td></tr>";
                        break;
                    case "hairtype":
                        $pageSubHeader .= "<tr><td>Тип волос:</td><td class=\"bold\">".$this->registry['hairtypes'][$value]."</td></tr>";
                        break;
                    case "skintype":
                        $pageSubHeader .= "<tr><td>Тип кожи:</td><td class=\"bold\">".$this->registry['skintypes'][$value]."</td></tr>";
                        break;
                    case "firm":    
                        $pageSubHeader .= "<tr><td>Бренд:</td><td class=\"bold\">".$this->registry['firms'][$value]->name."</td></tr>";
                        break;
                    case "problem":    
                        $pageSubHeader .= "<tr><td>Проблема:</td><td class=\"bold\">".$this->registry['problems'][$value]."</td></tr>";
                        break;
                    case "description":
                        $pageSubHeader .= "<tr><td>Описание:</td><td class=\"bold\">".$value."</td></tr>";
                        break;                        
                    case "howTo":
                        $pageSubHeader .= "<tr><td>Способ применения:</td><td class=\"bold\">".$value."</td></tr>";
                        break;
                    case "madeOf":
                        $pageSubHeader .= "<tr><td>Состав:</td><td class=\"bold\">".$value."</td></tr>";
                        break;
                    case "category":
                        $pageSubHeader .= "<tr><td>Категория:</td><td class=\"bold\">".$this->registry['categories'][$value]."</td></tr>";
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
    
    function performSearch($criteria) {
        $foundgoods=array();
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
            if ($found) {
                $foundgoods[$goodId] = $good;
            }
        }
        return $foundgoods;
    }

}
