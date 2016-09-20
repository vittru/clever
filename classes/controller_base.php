<?php


Abstract Class Controller_Base {

    protected $registry;

    function __construct($registry) {
        $this->registry = $registry;
        $this->registry['template']->set('user', $_SESSION['user']);
        $this->registry['template']->set('total', $this->getCartTotal());
    }

    abstract function index();
        
    function checkEmail($email) {
        $error="";
        if (trim($email) == "") {
            $error = $error .  "Пустая почта<br>"; 
        } else {
            if (!preg_match('/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/is', trim($email))) $error = $error . "Ваша почта кажется нам подозрительной<br>";
        }
        return $error;
    }
    
    function sendMail($to, $subject, $message) {
        $headers = 'From: clever@clubclever.ru' . "\r\n" .
            'Reply-To: clever@clubclever.ru' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }  
    
    function getCartTotal() {
        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['goods'][$cartItem->goodId];
                $size = $good->sizes[$cartItem->sizeId];
                $price = $size->getPrice($good->sale);
                $total = $total + $cartItem->quantity * $price; 
            }         
        }
        return $total;
    }
}


