<?php

Class Controller_Showgood Extends Controller_Base {
        
    function index() {
        
        if (isset($_GET['id'])) {
            $good = $this->registry['model']->getGood($_GET['id']);
            if (!$good) {
                $this->registry['template']->show('404');
            } else {   
                $this->showGood($good);
            }               
        } else {    
            $rt=explode('/', $_GET['route']);
            $route=$rt[(count($rt)-1)];
            $goodId = $this->registry['model']->getObjectIdByUrl('goods', $route);
            if (!$goodId)
                $this->registry['template']->show('404');
            else {
                $this->showGood($this->registry['model']->getGood($goodId));
            }    
        }
    }
    
    private function showGood($good) {
        $pagePath = $_SERVER['HTTP_REFERER'];
        $this->registry['model']->logVisit(30, $good->id);
        //if (isset($_GET['pm']))
        //    $pm = true;
        //else 
            $pm = false;
        $this->registry['template']->set('pm', $pm);
        if (isset($_GET['bb']))
            $bb = true;
        else 
            $bb = false;
        $this->registry['template']->set('bb', $bb);
        $this->registry['template']->set('showGood', $good);
        $this->registry['template']->set('breadcrumbs', $this->getBreadcrumbs(NULL, NULL, $good));
        $h1 = str_replace('"', '\'', $good->name);
        $h1 = str_replace('&nbsp;', ' ', $h1);
        $this->registry['template']->set('metaTitle', $h1 . ' в Самаре - купить, цена, фото | Экомаркет Клевер');
        $this->registry['template']->set('metaDescription', 'Продажа эко косметики — ' . $h1 . '. Купить в экомаркете Клевер с доставкой в Самаре.');
        $this->registry['template']->set('metaKeywords', $h1);
        
        $this->registry['template']->set('hasProblems', $good->hasProblems());
        $this->registry['template']->set('hasEffects', $good->hasEffects());
        $this->registry['template']->set('hasSkintypes', $good->hasSkintypes());
        $this->registry['template']->set('hasHairtypes', $good->hasHairtypes());
        $this->registry['template']->set('pagePath', $pagePath);
        $this->registry['template']->set('reviews', $this->registry['model']->getGoodReviews($good->id));
        $this->registry['template']->show('showgood');        
    }
    
    function emailMe() {
        if (isset($_GET['good']) and isset($_GET['address'])) {
            $good = $_GET['good'];
            $address = $_GET['address'];
            $this->registry['model']->logVisit(37, $good);
            $to      = $this->registry['mainemail'];
            $subject = 'Сообщить о поступлении товара';
            $message = '<html><body><h2>Сообщить о поступлении товара</h2>' .
                    "<p>Пользователь " . $_SESSION['user']->name . " настойчиво просит сообщить ему/ей о поступлении товара <a href='" . siteName . "/showgood?id=" . $good ."'>" . $this->registry['model']->getGood($good)->name ."</a> на склад.</p>" . 
                    "<p>Сообщить необходимо по следующему адресу: " . htmlspecialchars($address) . "</p></body></html>";
            $this->sendMail($to, $subject, $message);
        }    
    }
    
    function review() {
        if (isset($_POST['goodId'])) {
            $this->registry['model']->logVisit(40, $_POST['goodId']);
            if ($_POST['clovers'] || trim($_POST['text'])) {
                $this->registry['model']->addReview($_POST['goodId'], $_POST['reviewId'], $_POST['clovers'], htmlspecialchars($_POST['author']), htmlspecialchars($_POST['text']), $_POST['reviewDate']);
            } else {
                echo 'Пожалуйста оцените товар или напишите отзыв'; 
            }
        }
    }
    
    function deletereview() {
        if (isset($_POST['reviewId'])) {
            $this->registry['model']->deleteReview($_POST['reviewId']);
        }
    }
}    