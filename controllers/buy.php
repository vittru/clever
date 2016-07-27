<?php

Class Controller_Buy Extends Controller_Base {
    
    function index() {
        $this->registry['model']->logVisit(25);
        $this->registry['template']->show('buy');
    }
    
    function complete() {
        $this->registry['model']->logVisit(26);
        //Save the order in DB
        $orderId = $this->registry['model']->saveOrder($_SESSION['user']->id, htmlspecialchars($_POST['name']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['phone']), htmlspecialchars($_POST['branch']), htmlspecialchars($_POST['takeDate']), htmlspecialchars($_POST['takeTime']), htmlspecialchars($_POST['city']." ".$_POST['address']));
        
        //Inform manager by email
        $this->informManager($orderId, $_POST);

        //Send email to client
        $this->informClient($orderId, $_POST);
        
        //Update warehouse
        //@TODO
        
        //Update user info
        if (!$_SESSION['user']->email) 
            $_SESSION['user']->email = $_POST['email'];
        if (!$_SESSION['user']->phone)
            $_SESSION['user']->phone = $_POST['phone'];
        $this->registry['model']->updateUser();
        
        //Clear the cart box
        unset($_SESSION['cart']);
        
        //Show the results
        $this->registry['template']->set('orderId', $orderId);
        $this->registry['template']->show('complete');
    }
    
    private function informManager($orderId, $parameters) {
        $to      = 'clubclever63@gmail.com';
        $subject = 'Новый заказ №'.$orderId;
        $message = 'На сайте новый заказ' . "\r\n" .
                "Заказ №" . $orderId . "\r\n" .
                "Покупатель: " . $parameters['name'] . "\r\n" . 
                "Email: " . $parameters['email'] . "\r\n" . 
                "Телефон: " . $parameters['phone'] . "\r\n" .
                "Товары: " . "\r\n";
        
        $total = 0;
        foreach($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['goods'][$cartItem->goodId];
            $size = $good->sizes[$cartItem->sizeId];
            $price = $size->getPrice($good->sale) * $cartItem->quantity;
            $total += $price;
            $message = $message . "| " . $size->code . " | " . $good->name . " " 
                    . $size->size . " | ".$cartItem->quantity . " | " . $price . "руб. | \r\n";
        }    
        $message = $message . "Сумма заказа: " . $total . " руб. \r\n";
        if ($parameters['branch']) {
            $message = $message . "Самовывоз из " . $this->registry['branсhes'][$parameters['branch']]->address . "\r\n";
            if ($parameters['takeDate'])
                $message = $message . "Клиент готов приехать: " . $parameters['takeDate'] . " " . $parameters['takeTime'];
        } else {
            $message = $message . "Доставка курьером по адресу: " . $parameters['city'] . ", " . $parameters['address'];
        }
        $this->sendMail($to, $subject, $message);
    }   
    
    private function informClient($orderId, $parameters) {
        $to      = $parameters['email'];
        $subject = 'Clever. Заказ №'.$orderId;
        $message = 'Ваш заказ добавлен на сайт. Менеджер свяжется с вами в ближайшее время.' . "\r\n" .
                "Заказ №" . $orderId . "\r\n" .
                "Покупатель: " . $parameters['name'] . "\r\n" . 
                "Email: " . $parameters['email'] . "\r\n" . 
                "Телефон: " . $parameters['phone'] . "\r\n";
        $this->sendMail($to, $subject, $message);
        
    }    
}    

