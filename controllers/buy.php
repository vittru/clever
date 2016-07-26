<?php

Class Controller_Buy Extends Controller_Base {
    
    function index() {
        $this->registry['model']->logVisit(25);
        $this->registry['template']->show('buy');
    }
    
    function complete() {
        $this->registry['model']->logVisit(26);
        //Save the order in DB
        $orderId = $this->registry['model']->saveOrder($_SESSION['user']->id, $_POST['name'], $_POST['email'], $_POST['phone']);
        
        //Inform manager by email
        $to      = 'vitaly.trusov@gmail.com';
        $subject = 'Новый заказ №'.$orderId;
        $message = 'На сайте новый заказ' . "\r\n" .
                "Заказ №" . $orderId . "\r\n" .
                "Покупатель: " . $_POST['name'] . "\r\n" . 
                "Email: " . $_POST['email'] . "\r\n" . 
                "Телефон: " . $_POST['phone'] . "\r\n" .
                "Товары: " . "\r\n";
        
        $total = 0;
        foreach($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['goods'][$cartItem->goodId];
            $size = $good->sizes[$cartItem->sizeId];
            $price = $size->getPrice($good->sale) * $cartItem->quantity;
            $total += $price;
            $message = $message . "| " . $size->code . " | " . $good->name . " " 
                    . $size->size . " | ".$cartItem->quantity . " | " . $price . "руб. | \r\n";
            //$this->registry['logger']->lwrite($message);
        }    
        $message = $message . "Сумма заказа: " . $total . " руб. \r\n";
        if ($_POST['branch']) {
            $message = $message . "Самовывоз из " . $this->registry['branhes'][$_POST['branch']]->address;
            if ($_POST['takeDate'])
                $message = $message . "Клиент готов приехать в: " . $_POST['takeDate'] . " " . $_POST['takeTime'];
        } else {
            $message = $message . "Доставка курьером по адресу: " . $_POST['city'] . ", " . $_POST['address'];
        }
        
        
        $this->sendMail($to, $subject, $message);
        
        //Clear the cart box
        unset($_SESSION['cart']);
        
        //Show the results
        $this->registry['template']->set('orderId', $orderId);
        $this->registry['template']->show('complete');
    }    
}    

