<?php

Class Controller_Sale Extends Controller_Base {

    function index() {
        if ($this->registry['isadmin']) {
            $this->registry['template']->show('sale');
        } else {   
            $this->registry['template']->show('404');
        }    
    }
    
    function save() {
        if ($this->registry['isadmin']) {
            $mentypes = array();
            $cats = array();
            $firms = array();
            $supercats = array();
            foreach ($_POST as $name => $val) {
                if (strpos($name, 'mentype') !== false) {
                    $typeId = substr($name, 7);
                    array_push($mentypes, $typeId);
                }
                if (strpos($name, 'cat') !== false) {
                    $catId = substr($name, 3);
                    array_push($cats, $catId);
                }
                if (strpos($name, 'firm') !== false) {
                    $firmId = substr($name, 4);
                    array_push($firms, $firmId);
                }
                if (strpos($name, 'superc') !== false) {
                    $scId = substr($name, 6);
                    array_push($supercats, $scId);
                }
            }
            echo $this->registry['model']->setSale($_POST['sale'], $firms, $mentypes, $supercats, $cats) . " товаров обновлено";
        } else {   
            $this->registry['template']->show('404');
        }    
    }
}
