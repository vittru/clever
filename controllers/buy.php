<?php

Class Controller_Buy Extends Controller_Base {
    
    function index() {
        if (isset($_SESSION['cart']) and sizeof($_SESSION['cart']) > 0) {
            $this->registry['model']->logVisit(25);
            $this->registry['template']->show('buy');
        } else {
            $this->registry['model']->logVisit(404, false, $_SERVER['QUERY_STRING']);
            $this->registry['template']->show('404');
        }    
    }
    
    function complete() {
        if (isset($_SESSION['cart']) and sizeof($_SESSION['cart']) > 0 and $_SERVER['REQUEST_METHOD'] == 'POST') {
            //Save the order in DB
            $orderId = $this->registry['model']->saveOrder($_SESSION['user']->id, htmlspecialchars($_POST['name']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['phone']), htmlspecialchars($_POST['branch']), htmlspecialchars($_POST['takeDate']), htmlspecialchars($_POST['takeTime']), htmlspecialchars($_POST['city']." ".$_POST['address']), htmlspecialchars(trim($_POST['promo'])));
            $this->registry['model']->logVisit(26, $orderId);

            //Inform manager by email
            $this->informManager($orderId, $_POST);

            //Send email to client
            $this->informClient($orderId, $_POST);
            
            //Update bonuses
            if ($_SESSION['user']->name) {
                $bonus = $this->registry['model']->updateBonus($orderId, $_SESSION['user']->bonus);
                $_SESSION['user']->bonus += $bonus;
            }
            
            //Update warehouse
            //@TODO

            //Update user info
            if (!$_SESSION['user']->email) 
                $_SESSION['user']->email = $_POST['email'];
            if (!$_SESSION['user']->phone)
                $_SESSION['user']->phone = $_POST['phone'];
            $_SESSION['user'] = $this->registry['model']->updateUser($_SESSION['user']);

            //Clear the cart box
            unset($_SESSION['cart']);

            //Show the results
            $this->registry['template']->set('orderId', $orderId);
            $this->registry['template']->set('bonus', $bonus);
            $this->registry['template']->show('complete');
        } else {
            $this->registry['template']->show('404');
        }    
    }
    
    private function informManager($orderId, $parameters) {
        $to      = 'clubclever63@gmail.com';
        $subject = 'Новый заказ №'.$orderId;
        $message = 'На сайте новый заказ' . "\r\n" .
                "Заказ №" . $orderId . "\r\n" .
                "Покупатель: " . $parameters['name'] . "\r\n" . 
                "Email: " . $parameters['email'] . "\r\n" . 
                "Телефон: " . $parameters['phone'] . "\r\n" . 
                $this->getGoodsForLetter($parameters['promo']) .
                $this->getDeliveryForLetter($parameters);
        $this->sendMail($to, $subject, $message);
    }   
    
    private function getGoodsForLetter($promo) {
        $message = "Товары: " . "\r\n";
        
        foreach($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            $size = $good->sizes[$cartItem->sizeId];
            $price = $size->getPrice($good->sale) * $cartItem->quantity;
            $message = $message . "| " . $size->code . " | " . str_replace('&nbsp;', ' ' , $good->name) . " " 
                    . str_replace('&nbsp;', ' ' , $size->size) . " | ".$cartItem->quantity . " | " . $price . " руб. | \r\n";
        }    
        $promoAmount = 0;
        if ($promo){
            $message = $message . "Промо-код: " . $promo . "\r\n";
            $promoId = $this->registry['model']->getPromoId(trim($promo));
            $promoAmount = $this->registry['model']->getPromoAmount($promoId);
        }   
        $total = $this->getCartTotal() - $promoAmount['amount'] - floor(($this->getCartTotal() * $promoAmount['percent'] / 100));
        if ($total < 0)
            $total = 0;
        $message = $message . "Сумма заказа: " . $total . " руб. \r\n";
        return $message;
    }
    
    private function getDeliveryForLetter($parameters) {
        $message = '';
        if ($parameters['branch']) {
            $branch = $this->registry['branches'][$parameters['branch']];
            $message = "Самовывоз из " . $branch->address . "\r\n";
            if ($parameters['takeDate'])
                $message = $message . "Желаемое время самовывоза: " . $parameters['takeDate'] . " в " . $parameters['takeTime'];
        } else {
            $message = $message . "Доставка курьером по адресу: " . $parameters['city'] . ", " . $parameters['address'];
        }
        return $message;
    }
    
    private function informClient($orderId, $parameters) {
        $to      = $parameters['email'];
        $subject = 'Clever. Заказ №'.$orderId;
        $message = 'Ваш заказ добавлен на сайт. Менеджер свяжется с вами в ближайшее время.' . "\r\n" . "\r\n" .
                "Заказ №" . $orderId . "\r\n" .
                "Покупатель: " . $parameters['name'] . "\r\n" . 
                "Email: " . $parameters['email'] . "\r\n" . 
                "Телефон: " . $parameters['phone'] . "\r\n" . "\r\n" .
                $this->getGoodsForLetter($parameters['promo']) . "\r\n" .
                $this->getDeliveryForLetter($parameters);

        $this->registry['logger']->lwrite($message);
        $this->sendMail($to, $subject, $message);
    }

    function checkpromo() {
        $error = '';
        $discount = 0;
        $promo = $_GET['promo'];
        if ($promo) {
            $discount = $this->registry['model']->checkPromo(htmlspecialchars($promo));
            if ($discount == 0)
                $error = 'Такого промокода у нас нет';
        } else {
            $discount = 0;
        }    
        if ($discount == -1) {
            $error = 'Вы уже использовали этот промокод';
            $discount = 0;
        };
        $total = $this->getCartTotal() - $discount['amount'] - floor($this->getCartTotal() * $discount['percent'] / 100);
        if ($total < 0)
            $total = 0;
        $arr = array('error' => $error, 'discount' => $discount['amount'], 'percent' => $discount['percent'], 'total' => $total);
        echo json_encode($arr);
    }    
}    

