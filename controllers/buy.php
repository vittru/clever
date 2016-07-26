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
        //Clear the cart box
        unset($_SESSION['cart']);
        
        //Inform manager by email
        $to      = 'vitaly.trusov@gmail.com';
        $subject = 'Новый заказ №'.$orderId;
        $message = 'На сайте новый заказ';
        $headers = 'From: clever@clubclever.ru' . "\r\n" .
            'Reply-To: clever@clubclever.ru' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
        
        //Show the results
        $this->registry['template']->set('orderId', $orderId);
        $this->registry['template']->show('complete');
    }    
}    

