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
            if ($_POST['payment'] == 'card')
                $card = 1;
            else
                $card = 0;
            $orderId = $this->registry['model']->saveOrder($_SESSION['user']->id, htmlspecialchars($_POST['name']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['phone']), htmlspecialchars($_POST['branch']), htmlspecialchars($_POST['takeDate']), htmlspecialchars($_POST['takeTime']), htmlspecialchars($_POST['city']." ".$_POST['address']), htmlspecialchars(trim($_POST['promo'])), $_POST['bonus'], $card);
            $this->registry['model']->logVisit(26, $orderId);

            //Inform manager by email
            $this->informManager($orderId, $_POST);

            //Send email to client
            $this->informClient($orderId, $_POST);
            
            //Update bonuses
            if ($_SESSION['user']->name and !$_POST['bonus'] and !$_POST['promo']) {
                $bonus = $this->registry['model']->updateBonus($orderId, $_SESSION['user']->bonus);
                $_SESSION['user']->bonus += $bonus;
            }
            
            if ($_SESSION['user']->name and $_POST['bonus']) {
                $_SESSION['user']->bonus -= $_POST['bonus'];
                $this->registry['model']->decreaseBonus($_SESSION['user']->id, $_SESSION['user']->bonus);
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

            if ($_POST['payment'] == 'card') {
                $this->registry['template']->set('payment', true);
                $this->registry['template']->set('sum', $this->registry['model']->getOrder($orderId)->total);
            } 
            $this->registry['template']->show('complete');
        } else {
            $this->registry['template']->show('404');
        }    
    }
    
    private function informManager($orderId, $parameters) {
        if ($parameters['payment'] == 'cash')
            $payment = 'наличными при получении';
        else 
            $payment = 'картой онлайн';
        $to      = $this->registry['mainemail'];
        $subject = 'Новый заказ №'.$orderId;
        $message = '<html><body><h2>На сайте новый заказ</h2>' .
                "<h3>Заказ №" . $orderId . "</h3>" .
                "<p><b>Покупатель:</b> " . htmlspecialchars($parameters['name']) . "</p>" . 
                "<p><b>Email:</b> " . htmlspecialchars($parameters['email']) . "</p>" . 
                "<p><b>Телефон:</b> " . htmlspecialchars($parameters['phone']) . "</p>" . 
                $this->getGoodsForLetter($parameters['promo'], $parameters['bonus']) .
                $this->getDeliveryForLetter($parameters) . 
                '<p><b>Оплата:</b> ' . $payment . '</p></body></html>';
        $this->sendMail($to, $subject, $message);
    }   
    
    private function getGoodsForLetter($promo, $bonus) {
        $message = "<h3>Товары</h3>";
        
        $message .= "<table width=100% border=1><tr><th>Артикул</th><th>Имя</th><th>Количество</th><th>Цена</th></tr>";
        foreach($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            $size = $good->sizes[$cartItem->sizeId];
            $price = $cartItem->price * $cartItem->quantity;
            $message .= "<tr><td>" . $size->code . "</td><td>" . str_replace('&nbsp;', ' ' , $good->name) . " " 
                    . str_replace('&nbsp;', ' ' , $size->size) . "</td><td>".$cartItem->quantity . "</td><td>" . $price . " руб. </td></tr>";
        }    
        $message .= "</table>";
        $promoAmount = 0;
        if ($promo){
            $message .= "<p><b>Промо-код:</b> " . htmlspecialchars($promo) . "</p>";
            $promoId = $this->registry['model']->getPromoId(trim($promo));
            $promoAmount = $this->registry['model']->getPromoAmount($promoId);
        }
        if ($bonus) {
            $message .= "<p><b>Использованные бонусы:</b> " . $bonus . "</p>";
        } else 
            $bonus = 0;
        $total = $this->getCartTotal() - $promoAmount['amount'] - floor(($this->getCartTotal() * $promoAmount['percent'] / 100)) - $bonus;
        if ($total < 0)
            $total = 0;
        $message .= "<p><b>Сумма заказа:</b> " . $total . " руб. </p>";
        return $message;
    }
    
    private function getDeliveryForLetter($parameters) {
        $message = '<h3>Доставка</h3>';
        if ($parameters['branch']) {
            $branch = $this->registry['branches'][$parameters['branch']];
            $message .= "<p><b>Самовывоз из:</b> " . $branch->address . "</p>";
            if ($parameters['takeDate'])
                $message .= "<p><b>Желаемое время самовывоза:</b> " . htmlspecialchars ($parameters['takeDate']) . " " . htmlspecialchars ($parameters['takeTime']) . '</p>';
        } else {
            $message = $message . "<p><b>Доставка курьером по адресу:</b> " . htmlspecialchars($parameters['city']) . ", " . htmlspecialchars($parameters['address']) . '</p>';
        }
        return $message;
    }
    
    private function informClient($orderId, $parameters) {
        $to      = $parameters['email'];
        $subject = 'Clever. Заказ №'.$orderId;
        $message = '<html><body><h2>Заказ №' . $orderId . '</h2>' .
                '<p>Ваш заказ добавлен на сайт www.clubclever.ru. Менеджер свяжется с вами в ближайшее время.</p><p></p>' .
                '<p>Мы будем информировать Вас о статусе заказа по email.</p>' .
                '<p>Отследить заказ Вы также можете на <a href="www.clubclever.ru/account/orders?id='. $orderId . '">нашем сайте</a></p>' .
                "<h3>Информация о заказе</h3>" .
                "<p><b>Покупатель:</b> " . $parameters['name'] . "</p>" . 
                "<p><b>Email:</b> " . $parameters['email'] . "</p>" . 
                "<p><b>Телефон:</b> " . $parameters['phone'] . "</p>" .
                $this->getGoodsForLetter($parameters['promo'], $parameters['bonus']) .
                $this->getDeliveryForLetter($parameters) . 
                '<p>Больше информации о наших акциях и товарах:</p>'.
                '<ul><li><a href="www.clubclever.ru">www.cluclever.ru</a></li>' .
                '<li><a href="https://vk.com/clubcleverru">http://vk.com/clubcleverru</a></li>' . 
                '<li><a href="http://www.instagram.com/clubclever.ru/">http://www.instagram.com/clubclever.ru</a></li></ul></body></html>';

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
        $total = $this->getCartTotal();
        if ($discount['amount'] > $total * 0.3) {
            $discount['percent'] = 30;
            $discount['amount'] = 0;
        }
        $total = $total - $discount['amount'] - floor($total * $discount['percent'] / 100);
        if ($total < 0)
            $total = 0;
        $arr = array('error' => $error, 'discount' => $discount['amount'], 'percent' => $discount['percent'], 'total' => $total);
        echo json_encode($arr);
    }    

    function checkbonus() {
        $error = '';
        $discount = 0;
        $bonus = $_GET['bonus'];
        if ($bonus) {
            if ($bonus > $_SESSION['user']->bonus)
                $error = 'У вас нет столько бонусов';
            else if ($bonus > floor($this->getCartTotal() * 0.3))
                $error = 'Бонусами можно оплатить только 30% покупки';
            if (!$error) {
                $discount = $bonus;
            }
        } else {
            $discount = 0;
        }    
        $total = $this->getCartTotal() - $discount;
        if ($total < 0)
            $total = 0;
        $arr = array('error' => $error, 'discount' => $discount, 'percent' => 0, 'total' => $total);
        echo json_encode($arr);
    }    
}    

