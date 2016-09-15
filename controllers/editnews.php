<?php

Class Controller_Editnews Extends Controller_Base {
        
    function index() {
        $this->registry['model']->logVisit(1002);
        if ($_SESSION['user']->email == 'Nataliya.zhirnova@gmail.com' or $_SESSION['user']->email == 'Tev0205@gmail.com')
            $this->registry['template']->show('editnews');
        else 
            $this->registry['template']->show('404');
    }
    
    function save() {
        $this->registry['model']->logVisit(1003);
        
        if (isset($_POST['forClients']))
            $forClients=1;
        else $forClients=0;        
        
        $newsId = $this->registry['model']->addNews($_POST['id'], $_POST['header'], $_POST['text'], $_POST['time'], $forClients);

        $this->loadNewsImage($_FILES["image"], $newsId);

        echo "Новость сохранена под номером " . $newsId;
        echo "<p><a href='/editnews?news=".$newsId ."'>Отредактировать новость</a></p>";
        echo "<p><a href='/editnews'>Создать новую</a></p>";
        echo "<p><a href='/'>На главную</a></p>";
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

    function loadNewsImage($image, $newsId) {
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


