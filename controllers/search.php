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
                switch ($key) {
                    case "name":
                        if (mb_stripos($good->name, $value)==false)
                            $found = false;
                        break;
                    case "effect":
                        if (!in_array($value, $good->effs))
                            $found = false;
                        break;
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
