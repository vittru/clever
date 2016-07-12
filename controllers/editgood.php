<?php

Class Controller_Editgood Extends Controller_Base {
        
    function index() {
        $this->registry['template']->show('editgood');
    }
    
    function save() {
        foreach ($_POST as $name => $val) {
            if ($name === 'brand'){
                $firmId=substr($val, 4);
            }
        }
        $goodId = $this->registry['model']->addGood($_POST['id'], htmlspecialchars($_POST['name']), htmlspecialchars($_POST['description']), $firmId, $_POST['sale'], htmlspecialchars($_POST['madeOf']), htmlspecialchars($_POST['howTo']));
        $this->registry['model']->deleteGoodCat($goodId);
        foreach ($_POST as $name => $val) {
            if (strpos($name, 'cat') !== false){
                $catId=substr($name, 3);
                $this->registry['model']->linkGoodCat($goodId, $catId);
            }
            if (strpos($name, 'prob') !== false){
                $probId=substr($name, 4);
                $this->registry['model']->linkGoodProb($goodId, $probId);
            }
            if (strpos($name, 'eff') !== false){
                $effId=substr($name, 3);
                $this->registry['model']->linkGoodEff($goodId, $effId);
            }
            if (strpos($name, 'skintype') !== false){
                $skintypeId=substr($name, 8);
                $this->registry['model']->linkGoodST($goodId, $skintypeId);
            }
            if (strpos($name, 'hairtype') !== false){
                $hairtypeId=substr($name, 8);
                $this->registry['model']->linkGoodHT($goodId, $hairtypeId);
            }
        }
        echo "good saved " . $goodId;
    }
}


