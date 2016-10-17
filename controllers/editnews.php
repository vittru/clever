<?php

Class Controller_Editnews Extends Controller_Base {
        
    function index() {
        $this->registry['model']->logVisit(1002);
        if ($this->registry['isadmin'])
            $this->registry['template']->show('editnews');
        else 
            $this->registry['template']->show('404');
    }
    
    function remove() {
        if ($this->registry['isadmin']) {
            $this->registry['model']->removeNews($_GET['news']);
            $this->registry['template']->set('news', $this->registry['model']->getNews());
            $this->registry['template']->show('news');
        } else 
            $this->registry['template']->show('404');            
    }
    
    function save() {
        if ($this->registry['isadmin']) {

            if (isset($_POST['forClients']))
                $forClients=1;
            else $forClients=0;        

            $newsId = $this->registry['model']->addNews($_POST['id'], $_POST['header'], $_POST['text'], $_POST['time'], $forClients);
            $this->registry['model']->logVisit(1003, $newsId);

            $this->loadNewsImage($_FILES["image"], $newsId);
    
            $this->registry['template']->set('news', $this->registry['model']->getNews());
            $this->registry['template']->show('news');
        } else 
            $this->registry['template']->show('404');            
    }
    
    private function loadNewsImage($image, $newsId) {
        if (getimagesize($image["tmp_name"])) {
            $targetFileJpg = 'images/news/news'.$newsId.'.jpg';
            $targetFilePng = 'images/news/news'.$newsId.'.png';
            if ($image["size"] > 500000) {
                echo "Очень большая картинка<br>";
            } else {
                if(pathinfo(basename($image["name"]), PATHINFO_EXTENSION) == "jpg") {
                    $targetFile = $targetFileJpg;
                } else if ((pathinfo(basename($image["name"]), PATHINFO_EXTENSION) == "png")) {
                    $targetFile=$targetFilePng;
                } else {    
                    echo "Мы поддерживаем только jpg и png. Поправьте картинку<br>";
                }    
                if ($targetFile) {
                    if(file_exists($targetFileJpg) or file_exists($targetFilePng)) {
                        unlink($targetFileJpg);
                        unlink($targetFilePng);
                    }    
                    if(move_uploaded_file($image["tmp_name"], $targetFile)) {
                        echo "Картинка залита<br>";
                    } else {
                        echo "Картинка не залита<br>";
                    }
                }
            }
        }

    }
    
    
}


