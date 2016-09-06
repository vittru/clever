<?php

Class Controller_Catalog Extends Controller_Base {

    function index() {
        //$this->registry['model']->logVisit(2);
        $this->registry['template']->show('404');
    }

    function firm() {
        $this->registry['model']->logVisit(3);
        $firmId=$_GET['id'];
        if ($firmId) {
            $firm = $this->registry['model']->getFirm($firmId);
            $this->registry['template']->set('firm', $firm);
        } else
            $this->registry['template']->set('firms', $this->registry['firms']);
        $this->registry['template']->show('firm');
    }
    
    function type() {
        $this->registry['model']->logVisit(4);
        $typeId=$_GET['id'];
        if ($typeId) {
            $firms = $this->registry['model']->getTypeFirms($typeId);
            $selectedFirms = array();
            foreach($this->registry['firms'] as $id=>$name) {
                if (in_array($id, $firms))
                    $selectedFirms[$id] = $name;
            } 
            $this->registry['template']->set('firms', $selectedFirms);
            $this->registry['template']->set('type', $this->registry['types'][$typeId]);
            $this->registry['template']->set('goods', $this->registry['goods']);
        } else
            $this->registry['template']->set('types', $this->registry['types']);
        $this->registry['template']->show('type');
    }    
}


