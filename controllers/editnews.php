<?php

Class Controller_Editnews Extends Controller_Base {
        
    function index() {
        if ($this->registry['isadmin']) {
            $this->registry['model']->logVisit(1002);
            $this->registry['template']->show('editnews');
        } else 
            $this->registry['template']->show('404');
    }
    
    function remove() {
        if ($this->registry['isadmin']) {
            unlink('images/news/news'.$_GET['news'].'.png');
            unlink('images/news/news'.$_GET['news'].'.jpg');
            unlink('images/banners/news'.$_GET['news'].'.png');
            unlink('images/banners/news'.$_GET['news'].'.jpg');
            $this->registry['model']->removeNews($_GET['news']);
            header("LOCATION: ../news");
        } else 
            $this->registry['template']->show('404');            
    }
    
    function save() {
        if ($this->registry['isadmin']) {

            if (isset($_POST['forClients'])) {
                $forClients = 1;
            } else {
                $forClients = 0;
            }

            if (isset($_POST['banner'])) {
                $banner = 1;
            } else {
                $banner = 0;
            }

            if (isset($_POST['action'])) {
                $action = 1;
            } else {
                $action = 0;
            }
            $newsId = $this->registry['model']->addNews($_POST['id'], $_POST['header'], $_POST['text'], $_POST['time'], $forClients, $banner, $_POST['end'], $_POST['bannerlink'], $action);
            $this->registry['model']->logVisit(1003, $newsId);

            $this->loadNewsImage($_FILES["image"], $newsId, $banner);

            header("LOCATION: ../news");
        } else {
            $this->registry['template']->show('404');
        }
    }
    
    private function loadNewsImage($image, $newsId, $banner) {
        $targetFileJpg = 'images/news/news'.$newsId.'.jpg';
        $targetFilePng = 'images/news/news'.$newsId.'.png';
        $bannerFileJpg = 'images/banners/news'.$newsId.'.jpg';
        $bannerFilePng = 'images/banners/news'.$newsId.'.png';
        if (!$banner) {
            unlink($bannerFileJpg);
            unlink($bannerFilePng);
        }
        if (getimagesize($image["tmp_name"])) {
            if ($image["size"] > 500000) {
                echo "Очень большая картинка<br>";
            } else {
                if(pathinfo(basename($image["name"]), PATHINFO_EXTENSION) == "jpg") {
                    $targetFile = $targetFileJpg;
                    $bannerFile = $bannerFileJpg;
                } else if ((pathinfo(basename($image["name"]), PATHINFO_EXTENSION) == "png")) {
                    $targetFile = $targetFilePng;
                    $bannerFile = $bannerFilePng;
                } else {    
                    echo "Мы поддерживаем только jpg и png. Поправьте картинку<br>";
                }    
                if ($targetFile) {
                    unlink($targetFileJpg);
                    unlink($targetFilePng);
                    unlink($bannerFileJpg);
                    unlink($bannerFilePng);
                    if(move_uploaded_file($image["tmp_name"], $targetFile)) {
                    } else {
                        echo "Картинка не залита<br>";
                    }
                }
            }
        }
        if ($banner) {
            copy($targetFileJpg, $bannerFileJpg);
            copy($targetFilePng, $bannerFilePng);
        }
    }
}