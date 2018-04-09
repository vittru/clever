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
        $this->applyDiscounts();
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
        $this->applyDiscounts();
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
    
    private function applyDiscounts() {
        $this->makDiscounts();
    }
    
    private function bubbleBallDiscounts() {
        $discount = false;
        foreach ($_SESSION['cart'] as $cartItem) {
            if ($cartItem->goodId>=150 and $cartItem->goodId<=156) {
                $discount = true;
                break;
            }
        }
        if ($discount) {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (($cartItem->goodId < 150 or $cartItem->goodId > 156) and !$cartItem->sale and $this->registry['model']->getGood($cartItem->goodId)->firmId == 3) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 20;
                    $cartItem->price = ceil($cartItem->price * 0.8);
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (($cartItem->goodId < 150 or $cartItem->goodId > 156) and $cartItem->sale == 20 and $this->registry['model']->getGood($cartItem->goodId)->firmId == 3) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = ceil($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }

    private function makDiscounts() {
        $discount = false;
        foreach ($_SESSION['cart'] as $cartItem) {
            if ($cartItem->goodId == 547) {
                $discount = true;
                break;
            }
        }
        if ($discount) {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (($cartItem->goodId != 547) and !$cartItem->sale and $this->registry['model']->getGood($cartItem->goodId)->firmId == 3) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 17;
                    $cartItem->price = ceil($cartItem->price * (0.83));
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (($cartItem->goodId != 547) and $cartItem->sale == 17 and $this->registry['model']->getGood($cartItem->goodId)->firmId == 3) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = ceil($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }

}
