<?php

Class Controller_Editvoc Extends Controller_Base {
        
    function index() {
        if ($this->registry['isadmin']) {
            $this->registry['model']->logVisit(1006);
            $this->registry['template']->set('editWord', $this->registry['model']->getVoc($_GET['voc']));
            $this->registry['template']->show('editvoc');
        } else {
            $this->registry['template']->show('404');
        }
    }
    
    function remove() {
        if ($this->registry['isadmin']) {
            $this->registry['model']->removeVoc($_GET['voc']);
            header("LOCATION: ../common/vocabulary");
        } else {
            $this->registry['template']->show('404');
        }
    }
    
    function save() {
        if ($this->registry['isadmin']) {

            $vocId = $this->registry['model']->addVoc($_POST['id'], $_POST['name'], $_POST['text']);

            $this->registry['model']->logVisit(1007, $vocId);

            header("LOCATION: ../common/vocabulary");
        } else 
            $this->registry['template']->show('404');            
    }
}