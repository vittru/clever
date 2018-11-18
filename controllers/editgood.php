<?php

Class Controller_Editgood Extends Controller_Base {
        
    function index() {
        if ($this->registry['isadmin']) {
            $this->registry['model']->logVisit(1000, $_GET['good']);
            $this->registry['template']->show('editgood');
        } else {
            $this->registry['template']->show('404');
        }
    }
    
    function save() {
        if ($this->registry['isadmin']) {
            foreach ($_POST as $name => $val) {
                if ($name === 'brand') {
                    $firmId = substr($val, 4);
                }
            }
            if (isset($_POST['hidden'])) {
                $hidden = 1;
            } else {
                $hidden = 0;
            }
            if (isset($_POST['popular'])) {
                $popular = 1;
            } else {
                $popular = 0;
            }

            $goodId = $this->registry['model']->addGood($_POST['id'], $_POST['name'], $_POST['description'], $_POST['shortdesc'], $firmId, $_POST['sale'], $_POST['madeOf'], $_POST['howTo'], $_POST['problem'], $_POST['bestbefore'], $_POST['precaution'], $hidden, $popular);
            $this->registry['model']->deleteGoodCat($goodId);
            foreach ($_POST as $name => $val) {
                if (strpos($name, 'mentype') !== false) {
                    $typeId = substr($name, 7);
                    $this->registry['model']->linkGoodType($goodId, $typeId);
                }
                if (strpos($name, 'cat') !== false) {
                    $catId = substr($name, 3);
                    $this->registry['model']->linkGoodCat($goodId, $catId);
                }
                if (strpos($name, 'eff') !== false) {
                    $effId = substr($name, 3);
                    $this->registry['model']->linkGoodEff($goodId, $effId);
                }
                if (strpos($name, 'prolist') !== false) {
                    $probId = substr($name, 7);
                    $this->registry['model']->linkGoodProblem($goodId, $probId);
                }
                if (strpos($name, 'skintype') !== false) {
                    $skintypeId = substr($name, 8);
                    $this->registry['model']->linkGoodST($goodId, $skintypeId);
                }
                if (strpos($name, 'hairtype') !== false) {
                    $hairtypeId = substr($name, 8);
                    $this->registry['model']->linkGoodHT($goodId, $hairtypeId);
                }
                if ($name == 'size1' and $val != "") {
                    $this->registry['model']->addGoodSize($goodId, $_POST['sizeId1'], $val, $_POST['price1'], $_POST['code1'], $_POST['instock1'], $_POST['sale1'], $_POST['bbsize1'], $_POST['bbprice1']);
                }
                if ($name == 'size2' and $val != "") {
                    $this->registry['model']->addGoodSize($goodId, $_POST['sizeId2'], $val, $_POST['price2'], $_POST['code2'], $_POST['instock2'], $_POST['sale2'], $_POST['bbsize2'], $_POST['bbprice2']);
                }
                if ($name == 'size3' and $val != "") {
                    $this->registry['model']->addGoodSize($goodId, $_POST['sizeId3'], $val, $_POST['price3'], $_POST['code3'], $_POST['instock3'], $_POST['sale3'], $_POST['bbsize3'], $_POST['bbprice3']);
                }
            }
            $this->loadImage($_FILES["image1"], 1, $goodId);
            $this->loadImage($_FILES["image2"], 2, $goodId);
            $this->loadImage($_FILES["image3"], 3, $goodId);


            $good = $this->registry['model']->getGood($goodId);
            $this->registry['template']->set('pm', false);
            $this->registry['template']->set('showGood', $good);
            $this->registry['template']->set('hasProblems', $good->hasProblems());
            $this->registry['template']->set('hasEffects', $good->hasEffects());
            $this->registry['template']->set('hasSkintypes', $good->hasSkintypes());
            $this->registry['template']->set('hasHairtypes', $good->hasHairtypes());
            $this->registry['model']->logVisit(1001, $goodId);
//            $this->registry['template']->show('showgood'); 
            header("LOCATION: ../showgood?id=" . $goodId);
        } else {
            $this->registry['template']->show('404');
        }
    }
    
    private function loadImage($image, $number, $goodId) {
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
                        unlink($targetFilePng);
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


