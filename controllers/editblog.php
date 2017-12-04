<?php

Class Controller_Editblog Extends Controller_Base {
        
    function index() {
        if ($this->registry['isadmin']) {
            $this->registry['model']->logVisit(1004);
            $this->registry['template']->show('editblog');
        } else 
            $this->registry['template']->show('404');
        }
    
    function remove() {
        if ($this->registry['isadmin']) {
            unlink('images/blog/blog'.$_GET['blog'].'.png');
            unlink('images/blog/blog'.$_GET['blog'].'.jpg');
            $this->registry['model']->removeBlog($_GET['blog']);
            header("LOCATION: ../common/blog");
        } else 
            $this->registry['template']->show('404');            
    }
    
    function save() {
        if ($this->registry['isadmin']) {

            $blogId = $this->registry['model']->addBlogEntry($_POST['id'], $_POST['header'], $_POST['author'], $_POST['url'], $_POST['text'], $_POST['date']);

            $this->registry['model']->logVisit(1005, $blogId);
            $this->loadBlogImage($_FILES["image"], $blogId);

            header("LOCATION: ../common/blog");
        } else 
            $this->registry['template']->show('404');            
    }
    
    private function loadBlogImage($image, $blogId) {
        $targetFileJpg = 'images/blogs/blog'.$blogId.'.jpg';
        $targetFilePng = 'images/blogs/blog'.$blogId.'.png';
        if (getimagesize($image["tmp_name"])) {
            if ($image["size"] > 500000) {
                echo "Очень большая картинка<br>";
            } else {
                if(pathinfo(basename($image["name"]), PATHINFO_EXTENSION) == "jpg") {
                    $targetFile = $targetFileJpg;
                } else if ((pathinfo(basename($image["name"]), PATHINFO_EXTENSION) == "png")) {
                    $targetFile = $targetFilePng;
                } else {    
                    echo "Мы поддерживаем только png и jpg. Поправьте картинку<br>";
                }
                if ($targetFile) {
                    unlink($targetFileJpg);
                    unlink($targetFilePng);
                    if(move_uploaded_file($image["tmp_name"], $targetFile)) {
                    } else {
                        echo "Картинка не залита<br>";
                    }
                }
            }
        }
    }
}
