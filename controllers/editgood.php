<?php

Class Controller_Editgood Extends Controller_Base {
        
    function index() {
        $this->registry['model']->logVisit(1000);
        $this->registry['template']->show('editgood');
    }
    
    function save() {
        $this->registry['model']->logVisit(1001);
        foreach ($_POST as $name => $val) {
            if ($name === 'brand'){
                $firmId=substr($val, 4);
            }
        }
        $this->registry['logger']->lwrite('**** START Saving product ****');
        $this->registry['logger']->lwrite($_POST['id']);
        $this->registry['logger']->lwrite($_POST['name']);
        $this->registry['logger']->lwrite($_POST['description']);
        $this->registry['logger']->lwrite($_POST['shortdesc']);
        $this->registry['logger']->lwrite($_POST['madeOf']);
        $this->registry['logger']->lwrite($_POST['howTo']);
        $this->registry['logger']->lwrite($_POST['problem']);
        $this->registry['logger']->lwrite($_POST['bestbefore']);
        $this->registry['logger']->lwrite($_POST['precaution']);
        $this->registry['logger']->lwrite('**** END Saving product ****');
        $goodId = $this->registry['model']->addGood($_POST['id'], $_POST['name'], $_POST['description'], $_POST['shortdesc'], $firmId, $_POST['sale'], $_POST['madeOf'], $_POST['howTo'], $_POST['problem'], $_POST['bestbefore'], $_POST['precaution']);
        $this->registry['model']->deleteGoodCat($goodId);
        foreach ($_POST as $name => $val) {
            if (strpos($name, 'mentype') !== false){
                $typeId=substr($name, 7);
                $this->registry['model']->linkGoodType($goodId, $typeId);
            }
            if (strpos($name, 'cat') !== false){
                $catId=substr($name, 3);
                $this->registry['model']->linkGoodCat($goodId, $catId);
            }
            if (strpos($name, 'eff') !== false){
                $effId=substr($name, 3);
                $this->registry['model']->linkGoodEff($goodId, $effId);
            }
            if (strpos($name, 'prolist') !== false){
                $probId=substr($name, 7);
                $this->registry['model']->linkGoodProblem($goodId, $probId);
            }
            if (strpos($name, 'skintype') !== false){
                $skintypeId=substr($name, 8);
                $this->registry['model']->linkGoodST($goodId, $skintypeId);
            }
            if (strpos($name, 'hairtype') !== false){
                $hairtypeId=substr($name, 8);
                $this->registry['model']->linkGoodHT($goodId, $hairtypeId);
            }
            if ($name=='size1' and $val!=""){
                $this->registry['model']->addGoodSize($goodId, $_POST['sizeId1'], $val, $_POST['price1'], $_POST['code1'], $_POST['instock1'], $_POST['sale1']);
            }
            if ($name=='size2' and $val!=""){
                $this->registry['model']->addGoodSize($goodId, $_POST['sizeId2'], $val, $_POST['price2'], $_POST['code2'], $_POST['instock2'], $_POST['sale2']);
            }
            if ($name=='size3' and $val!=""){
                $this->registry['model']->addGoodSize($goodId, $_POST['sizeId3'], $val, $_POST['price3'], $_POST['code3'], $_POST['instock3'], $_POST['sale3']);
            }
        }
        $this->loadImage($_FILES["image1"], 1, $goodId);
        $this->loadImage($_FILES["image2"], 2, $goodId);
        $this->loadImage($_FILES["image3"], 3, $goodId);
        
        
            
        echo "Товар сохранен под номером " . $goodId;
    }
    
    function loadImage($image, $number, $goodId) {
        if (getimagesize($image["tmp_name"])) {
            $targetFileJpg = 'images/goods/good'.$goodId.'-'.$number.'.jpg';
            $targetFilePng = 'images/goods/good'.$goodId.'-'.$number.'.png';
            if ($image["size"] > 500000) {
                echo "Очень большая картинка-".$number."<br>";
            } else {
                if(pathinfo(basename($image["name"]), PATHINFO_EXTENSION) == "jpg") {
                    $targetFile = $targetFileJpg;
                } else if ((pathinfo(basename($image["name"]), PATHINFO_EXTENSION) == "png")) {
                    $targetFile=$targetFilePng;
                } else {    
                    echo "Мы поддерживаем только jpg и png. Поправьте картинку ".$number."<br>";
                }    
                if ($targetFile) {
                    if(file_exists($targetFileJpg) or file_exists($targetFilePng)) {
                        unlink($targetFileJpg);
                        unlink($taregtFilePng);
                        echo 'У товара уже была картинка '.$number.', заменяю<br>';
                    }    
                    if(move_uploaded_file($image["tmp_name"], $targetFile)) {
                        echo "Картинка ".$number." залита<br>";
                    } else {
                        echo "Картинка ".$number." не залита<br>";
                    }
                }
            }
        }

    }
}


