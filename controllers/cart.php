<?php

Class Controller_Cart Extends Controller_Base {
    
    function index() {
        $this->registry['model']->logVisit(20);
        $this->registry['template']->show('cart');
    }

    function add() {
        $this->registry['model']->logVisit(21);
        $data = json_decode($_POST['data'], true);
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }    
        foreach ($data as $d) {
            $cartItem = new CartItem();
            $cartItem->goodId = $d['goodId'];
            $cartItem->quantity = $d['count'];
            $cartItem->sizeId = $d['sizeId'];
            $cartItem->price = $d['price'];
            $cartItem->sale = $d['sale'];
            $index = -1;
            foreach ($_SESSION['cart'] as $cI) {
                if ($cI->goodId == $cartItem->goodId and $cI->sizeId == $cartItem->sizeId and $cI->price == $cartItem->price) {
                    $index = array_search($cI, $_SESSION['cart']);
                    $_SESSION['cart'][$index]->quantity += $cartItem->quantity;
                    break;
                }    
            }    
            if ($index < 0) {
                array_push($_SESSION['cart'], $cartItem);
            }    
        }
    } 
    
    function remove() {
        $this->registry['model']->logVisit(22);
        $goodId = $_GET['id'];
        $sizeId = $_GET['sid'];
        foreach($_SESSION['cart'] as $cartItem) {
            if ($cartItem->goodId == $goodId and $cartItem->sizeId == $sizeId) {
                unset($_SESSION['cart'][array_search($cartItem, $_SESSION['cart'])]);
                break;
            }    
        }    
    }

    function update() {
        $count = $_GET['c'];
        if (!$count) {
            $this->remove();
        } else {    
            $this->registry['model']->logVisit(23);
            $this->updateCart($_GET['id'], $_GET['sid'], $count);
        }
    }

    private function updateCart($goodId, $sizeId, $count) {
        foreach($_SESSION['cart'] as $cartItem) {
            if ($cartItem->goodId == $goodId and $cartItem->sizeId == $sizeId) {
                $_SESSION['cart'][array_search($cartItem, $_SESSION['cart'])]->quantity = $count;
                break;
            }    
        }    
    }    
}