<?php

Class Controller_Buy Extends Controller_Base {
    
    function index() {
        if (isset($_SESSION['cart']) and sizeof($_SESSION['cart']) > 0) {
            $this->registry['model']->logVisit(25);
            $this->registry['template']->set("bonusAvailable", $this->getCartNoSaleTotal($_SESSION['cart']) > 0);
            $this->registry['template']->show('buy');
        } else {
            $this->registry['model']->logVisit(404, false, $_SERVER['QUERY_STRING']);
            $this->registry['template']->show('404');
        }    
    }
    
    function complete() {
        if (isset($_SESSION['cart']) and sizeof($_SESSION['cart']) > 0 and $_SERVER['REQUEST_METHOD'] == 'POST') {
            //Save the order in DB
            if ($_POST['payment'] == 'card') {
                $card = 1;
            } else {
                $card = 0;
            }
            $this->registry['model']->logVisit(26, $orderId);
            $orderId = $this->registry['model']->saveOrder($_SESSION['user']->id, htmlspecialchars($_POST['name']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['phone']), htmlspecialchars($_POST['branch']), htmlspecialchars($_POST['takeDate']), htmlspecialchars($_POST['takeTime']), htmlspecialchars($_POST['city']." ".$_POST['address']), htmlspecialchars(trim($_POST['promo'])), $_POST['bonus'], $card, $_POST['remarks'], $_SESSION['cart']);

            //Inform manager by email
            $this->informManager($orderId, $_POST, $_SESSION['cart']);

            //Send email to client
            $this->informClient($orderId, $_POST, $_SESSION['cart']);
            
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
            if (!$_SESSION['user']->email) {
                $_SESSION['user']->email = $_POST['email'];
            }
            if (!$_SESSION['user']->phone) {
                $_SESSION['user']->phone = $_POST['phone'];
            }
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
        
    private function informManager($orderId, $parameters, $goods) {
        if ($parameters['payment'] == 'cash') {
            $payment = 'наличными при получении';
        } else {
            $payment = 'картой онлайн';
        }
        $to      = $this->registry['mainemail'];
        $subject = 'Новый заказ №'.$orderId;
        $message = '<html><body><h2>На сайте новый заказ</h2>' .
                "<h3>Заказ №" . $orderId . "</h3>" .
                "<p><b>Покупатель:</b> " . htmlspecialchars($parameters['name']) . "</p>" . 
                "<p><b>Email:</b> " . htmlspecialchars($parameters['email']) . "</p>" . 
                "<p><b>Телефон:</b> " . htmlspecialchars($parameters['phone']) . "</p>" . 
                $this->getGoodsForLetter($goods, $parameters['promo'], $parameters['bonus']) .
                $this->getDeliveryForLetter($parameters);
        if ($parameters['payment']) {
            $message = $message . '<p><b>Оплата:</b> ' . $payment . '</p>' .
                '<p><b>Пожелания по заказу:</b> ' . htmlspecialchars($parameters['remarks']) . '</p></body></html>';
        } else {
            $message = $message . '<p>Заказ в один клик</p>' . '</body></html>';
        }
        $this->sendMail($to, $subject, $message);
    }   
    
    private function getGoodsForLetter($goods, $promo, $bonus) {
        $message = "<h3>Товары</h3>";
        
        $message .= "<table width=100% border=1><tr><th>Артикул</th><th>Имя</th><th>Количество</th><th>Цена</th></tr>";
        foreach($goods as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            $size = $good->sizes[$cartItem->sizeId];
            $price = $cartItem->price * $cartItem->quantity;
            $message .= "<tr><td>" . $size->code . "</td><td>" . str_replace('&nbsp;', ' ' , $good->name) . " " 
                    . str_replace('&nbsp;', ' ' , $size->size) . "</td><td>".$cartItem->quantity . "</td><td>" . $price . currency . "</td></tr>";
        }    
        $message .= "</table>";
        $promoAmount = 0;
        if ($promo){
            $message .= "<p><b>Промо-код:</b> " . htmlspecialchars($promo) . "</p>";
            $promoId = $this->registry['model']->getPromoId(trim($promo));
            $promoAmount = $this->registry['model']->getPromoAmount($promoId);
            $total = $this->getTotalWithPromo($promo, $promoAmount);
        }
        if ($bonus) {
            $message .= "<p><b>Использованные бонусы:</b> " . $bonus . "</p>";
            $total = $this->getCartTotal($goods) - $bonus;
        } else {
            $bonus = 0;
            $total = $this->getCartTotal($goods);
        }
        if ($total < 0) {
            $total = 0;
        }
        $message .= "<p><b>Сумма заказа:</b> " . $total . currency . " </p>";
        return $message;
    }
    
    private function getDeliveryForLetter($parameters) {
        $message = '<h3>Доставка</h3>';
        if ($parameters['branch']) {
            $branch = $this->registry['branches'][$parameters['branch']];
            $message .= "<p><b>Самовывоз из:</b> " . $branch->address . "</p>";
            if ($parameters['takeDate']) {
                $message .= "<p><b>Желаемое время самовывоза:</b> " . htmlspecialchars($parameters['takeDate']) . " " . htmlspecialchars($parameters['takeTime']) . '</p>';
            }
        } else if ($parameters['city']){
            $message = $message . "<p><b>Доставка курьером по адресу:</b> " . htmlspecialchars($parameters['city']) . ", " . htmlspecialchars($parameters['address']) . '</p>';
        } else {
            $message = '';
        }
        return $message;
    }
    
    private function informClient($orderId, $parameters, $goods) {
        $to      = $parameters['email'];
        $subject = 'Экомаркет "Клевер". Заказ №'.$orderId;
        $message = '<html><body><h2>Заказ №' . $orderId . '</h2>' .
                '<p>Благодарим Вас за заказ в Экомаркете "Клевер". Наш менеджер свяжется с вами в ближайшее время.</p><p></p>' .
                '<p>Отследить заказ Вы можете на <a href="www.ecomarketclever.ru/account/orders?id='. $orderId . '">нашем сайте</a></p>' .
                "<h3>Информация о заказе</h3>" .
                "<p><b>Покупатель:</b> " . $parameters['name'] . "</p>" . 
                "<p><b>Email:</b> " . $parameters['email'] . "</p>" . 
                "<p><b>Телефон:</b> " . $parameters['phone'] . "</p>" .
                $this->getGoodsForLetter($goods, $parameters['promo'], $parameters['bonus']) .
                $this->getDeliveryForLetter($parameters) . 
                '<p><b>Пожелания по заказу:</b> ' . htmlspecialchars($parameters['remarks']) . '</p>' . 
                '<p>Больше информации о наших акциях и товарах:</p>'.
                '<ul><li><a href="www.ecomarketclever.ru">www.ecomarketclever.ru</a></li>' .
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
            if ($discount == 0) {
                $error = 'Такого промокода у нас нет';
            }
        } else {
            $discount = 0;
        }    
        if ($discount == -1) {
            $error = 'Вы уже использовали этот промокод';
            $discount = 0;
        }
        $total = $this->getTotalWithPromo($promo, $discount);
        $arr = array('error' => $error, 'discount' => $discount['amount'], 'percent' => $discount['percent'], 'total' => $total);
        echo json_encode($arr);
    }    
    
    private function getTotalWithPromo($promo, $discount) {
        //For INSTA promo-code we ignore other sales
        if (strcasecmp($promo, 'INSTA') == 0) {
            $totalNoSale = $this->getCartTotal($_SESSION['cart']);
        } else {
            $totalNoSale = $this->getCartNoSaleTotal($_SESSION['cart']);
        }    
        if ($discount['amount'] > $totalNoSale * 0.3) {
            $discount['percent'] = 30;
            $discount['amount'] = 0;
        }
        $total = $this->getCartTotal($_SESSION['cart']) - $discount['amount'] - floor($totalNoSale * $discount['percent'] / 100);
        if ($total < 0) {
            $total = 0;
        }
        return $total;
    }

    function checkbonus() {
        $error = '';
        $discount = 0;
        $bonus = $_GET['bonus'];
        $total = $this->getCartNoSaleTotal($_SESSION['cart']);
        if ($bonus) {
            if ($bonus > $_SESSION['user']->bonus) {
                $error = 'У вас нет столько бонусов';
            } else if ($bonus > floor($total * 0.3)) {
                $error = 'Бонусами можно оплатить только 30% покупки';
            }
            if (!$error) {
                $discount = $bonus;
            }
        } else {
            $discount = 0;
        }    
        $total = $this->getCartTotal($_SESSION['cart']) - $discount;
        if ($total < 0) {
            $total = 0;
        }
        $arr = array('error' => $error, 'discount' => $discount, 'percent' => 0, 'total' => $total);
        echo json_encode($arr);
    }  
    
    function quick() {
        $error = $this->checkEmail($_POST['email']) . 
            $this->checkEmpty($_POST['phone'], 'Пустой телефон');
        $this->registry['logger']->lwrite('Error: '. $error);
        
        if ($error == '') {
            $this->registry['model']->logVisit(39);
            $data = json_decode($_POST['data'], true);
            foreach ($data as $d) {
                $cartItem = new CartItem();
                $cartItem->goodId = $d['goodId'];
                $cartItem->quantity = $d['count'];
                $cartItem->sizeId = $d['sizeId'];
                $cartItem->price = $d['price'];
                $cartItem->sale = $d['sale'];
                if (!$cartItems) {
                    $cartItems = [$cartItem];
                } else {
                    array_push($cartItems, $cartItem);
                }
            }
            $orderId = $this->registry['model']->saveOrder($_SESSION['user']->id, $_SESSION['user']->name, htmlspecialchars($_POST['email']), htmlspecialchars($_POST['phone']), NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Заказ в 1 клик', $cartItems);
            //Inform manager by email
            $this->informManager($orderId, $_POST, $cartItems);

            //Send email to client
            $this->informClient($orderId, $_POST, $cartItems);
            
            //Show the results
            echo $orderId;
        } else {
            echo $error;
        }
    }
    
}