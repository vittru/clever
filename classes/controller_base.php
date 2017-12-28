<?php


Abstract Class Controller_Base {

    protected $registry;

    function __construct($registry) {
        $this->registry = $registry;
        $this->registry['template']->set('user', $_SESSION['user'], true);
        $this->registry['template']->set('total', $this->getCartTotal(), true);
        $this->registry['template']->set('totalNoSale', $this->getCartNoSaleTotal(), true);
        $this->registry['template']->set('isadmin', $this->registry['isadmin'], true);
    }

    abstract function index();
        
    function checkEmail($email) {
        $error="";
        if (trim($email) == "") {
            $error = $error .  "Пустая почта<br>"; 
        } else {
            if (!preg_match('/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/is', trim($email))) {
                $error = $error . "Ваша почта кажется нам подозрительной<br>";
            }
        }
        return $error;
    }
    
    function sendMail($to, $subject, $message) {
        $headers = "From: 'Экомаркет Клевер' <" . $this->registry['mainemail'] . "> \r\n" .
            'Reply-To: ' . $this->registry['mainemail'] . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        mail($to, $subject, $message, $headers);
    }  
    
    function getCartTotal() {
        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $total = $total + $cartItem->quantity * $cartItem->price; 
            }         
        }
        return $total;
    }
    
    function getCartNoSaleTotal() {
        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (!$cartItem->sale) {
                    $total = $total + $cartItem->quantity * $cartItem->price; 
                }    
            }         
        }
        return $total;        
    }
    
    function getBreadcrumbs($supercat, $category, $good) {
        $crumbs['Каталог'] = '/catalog/sc';
        if ($supercat) {
            $crumbs[$supercat->name] = NULL;
        } else if ($category) {
            foreach ($this->registry['supercats'] as $sc) {
                if ($sc->id == $category->supercatId) {
                    $superc = $sc;
                    break;
                }    
            }            
            $crumbs[$superc->name] = '/catalog/sc/' . $superc->url;
            $crumbs[$category->name] = NULL;
        } else if ($good) {
            $categoryId = array_values($good->cats)[0];
            $categ = $this->registry['model']->getCategory($categoryId); 
            foreach ($this->registry['supercats'] as $sc) {
                if ($sc->id == $categ->supercatId) {
                    $superc = $sc;
                    break;
                }    
            }
            $crumbs[$superc->name] = '/catalog/sc/' . $superc->url;
            $crumbs[$categ->name] = '/catalog/category/' . $categ->url;
            $crumbs[$good->name] = NULL;
        }    
        return $crumbs;
    }
}