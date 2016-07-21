<?php

Class Controller_Search Extends Controller_Base {

    function index() {
        $this->registry['model']->logVisit(10);
        $this->registry->set('foundgoods', $this->performSearch($_GET));
        $this->registry['template']->show('search');
    }
    
    function performSearch($criteria) {
        $foundgoods=array();
        foreach ($this->registry['goods'] as $goodId=>$good) {
            $found = true;
            foreach($criteria as $key => $value){
                if (!empty($value) and $key!="route") {
                    switch ($key) {
                        case "name":
                            if (mb_stripos($good->name, $value)===false)
                                $found = false;
                            break;
                        case "effect":
                            if (!in_array($value, $good->effs))
                                $found = false;
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
                            if (mb_stripos($good->description, $value)===false and mb_stripos($good->shortdesc, $value)===false)
                                $found = false;
                            break;                        
                        case "howTo":
                            if (mb_stripos($good->howTo, $value)===false)
                                $found = false;
                            break;
                        case "madeOf":
                            if (mb_stripos($good->madeOf, $value)===false)
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
