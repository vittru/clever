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
        $this->mustaevaCream();
    }
    
    //При покупке шампуня скидка на средства для волос 30%
    private function shampooDiscount() {
        $discount = false;
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if (in_array(7, $good->cats)) {
                $discount = true;
                break;
            }
        }
        if ($discount) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if (array_key_exists(1, $good->supercats) and (!in_array(7, $good->cats)) and !$cartItem->sale) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 30;
                    $cartItem->price = floor($cartItem->price * (0.7));
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (array_key_exists(1, $good->supercats) and (!in_array(7, $good->cats)) and $cartItem->sale == 30) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }
    
    //Если в корзине 5 и более товаров, то на все скидка 25%
    private function fiveGoodsDiscount() {
        if (sizeof($_SESSION['cart']) >= 5) {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (!$cartItem->sale) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 25;
                    $cartItem->price = floor($cartItem->price * (0.75));
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                if ($cartItem->sale == 25) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
            
        }
    }

    //Если в корзине >=3 товаров, то скидка 10%, если 6 и больше - то 20%
    private function progressiveCountDiscount() {
        if (sizeof($_SESSION['cart']) >= 3 && sizeof($_SESSION['cart']) < 6) {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (!$cartItem->sale || $cartItem->sale == 20) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 10;
                    $cartItem->price = floor($cartItem->price * (0.9));
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        } else 
            if (sizeof($_SESSION['cart']) >= 6) {
                foreach ($_SESSION['cart'] as $cartItem) {
                    if (!$cartItem->sale || $cartItem->sale == 10) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                        $cartItem->sale = 20;
                        $cartItem->price = floor($cartItem->price * (0.8));
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    }
                }
            } else 
                if (sizeof ($_SESSION['cart']) < 3){
                    foreach ($_SESSION['cart'] as $cartItem) {
                        if ($cartItem->sale == 10 || $cartItem->sale == 20) {
                            $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                            $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                            $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                            $cartItem->sale = 0;
                            $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                        }
                    }
                }
    }
    
    //При покупке шампуня скидка на средства для волос 20%
    private function shampooDiscount2() {
        $discount = false;
        $maxprice = 0;
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if (in_array(7, $good->cats)) {
                $discount = true;
                $maxprice = max($maxprice, $cartItem->price);
            }
        }
        if ($discount) {
            $this->registry['logger']->lwrite("Max price " . $maxprice);
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if (!$cartItem->sale and ((!in_array(7, $good->cats) and array_key_exists(1, $good->supercats)) or (in_array(7, $good->cats) and $cartItem->price < $maxprice))) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 20;
                    $cartItem->price = floor($cartItem->price * (0.8));
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
                if ($cartItem->sale == 20 and in_array(7, $good->cats) and $cartItem->price == $maxprice) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (array_key_exists(1, $good->supercats) and $cartItem->sale == 20) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }

    //При покупке скраба скидка на мыло - 100%
    private function scrubSoap0() {
        $discount = false;
        $minprice = 1000000;
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if (in_array(4, $good->cats) || in_array(36, $good->cats)) {
                $discount = true;
            }
            if (in_array(11, $good->cats)) {
                    $minprice = min($minprice, $cartItem->price);
                }   
            }
        if ($discount) {
            if ($minprice > 0) {
                foreach ($_SESSION['cart'] as $cartItem) {
                    $good = $this->registry['model']->getGood($cartItem->goodId);
                    if (in_array(11, $good->cats) && $cartItem->price == $minprice) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->sale = 100;
                        $cartItem->price = 0;
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    }
                }
            }    
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if (in_array(11, $good->cats) and $cartItem->price == 0) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }
    
    //Каждый третий товар Кристалл Декор стоит 1 рубль.
    private function crystallThird() {
        $crystalGoods = [];
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if ($good->firmId == 8) {
                array_push($crystalGoods, $good);
            }
        }
        if (sizeof($crystalGoods) >= 3) {
            function cmp($a, $b) {
                return $a->getPrice() < $b->getPrice();
            }
            usort($crystalGoods, "cmp");
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if ($good->firmId == 8) {
                    //We consider only 3rd and 6th goods. I doubt if anybody will add more than 6 Crystall goods to cart
                    if ($good->id == $crystalGoods[2]->id || (sizeof($crystalGoods) >= 6 && $good->id == $crystalGoods[5]->id)) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->sale = 100;
                        $cartItem->price = 1;
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    } else if ($cartItem->price == 1 && ($good->id != $crystalGoods[2]->id || (sizeof($crystalGoods) >= 6 && $good->id == $crystalGoods[5]->id))) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->price = $good->getPrice();
                        $cartItem->sale = 0;
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    }   
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if ($good->firmId == 8 and $cartItem->price == 1) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }
    
    //При покупке мыла скидка на средства для тела 20%
    private function soapDiscount2() {
        $discount = false;
        $maxprice = 0;
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if (in_array(11, $good->cats)) {
                $discount = true;
                $maxprice = max($maxprice, $cartItem->price);
            }
        }
        if ($discount) {
            $this->registry['logger']->lwrite("Max price " . $maxprice);
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if (!$cartItem->sale and ((!in_array(11, $good->cats) and array_key_exists(3, $good->supercats)) or (in_array(11, $good->cats) and $cartItem->price < $maxprice))) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 20;
                    $cartItem->price = floor($cartItem->price * (0.8));
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
                if ($cartItem->sale == 20 and in_array(11, $good->cats) and $cartItem->price == $maxprice) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (array_key_exists(3, $good->supercats) and $cartItem->sale == 20) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }

    //При покупке имбирной воды скидка на средства для лица 20%
    private function gingerDiscount() {
        $discount = false;
        $maxprice = 0;
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if ($good->id == 462) {
                $discount = true;
            }
        }
        if ($discount) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if (!$cartItem->sale and array_key_exists(2, $good->supercats) and $good->id != 462) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 20;
                    $cartItem->price = floor($cartItem->price * (0.8));
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (array_key_exists(2, $good->supercats) and $cartItem->sale == 20) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }
    
    //При покупке бальзама с маслом брокколи скидка на все 20%
    private function brokkoliDiscount() {
        $discount = false;
        foreach ($_SESSION['cart'] as $cartItem) {
            if ($cartItem->goodId == 51) {
                $discount = true;
            }
        }
        if ($discount) {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (!$cartItem->sale and $cartItem->goodId != 51) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 20;
                    $cartItem->price = floor($cartItem->price * (0.8));
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                if ($cartItem->goodId != 51 and $cartItem->sale == 20) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }

    //Каждый третий товар бесплатно.
    private function thirdFree() {
        $size = sizeof($_SESSION['cart']);
        if ($size >= 3) {
            $goods = [];
            foreach ($_SESSION['cart'] as $cartItem) {
                array_push($goods, $this->registry['model']->getGood($cartItem->goodId));
            }
            function cmp($a, $b) {
                return $a->getPrice() < $b->getPrice();
            }
            usort($goods, "cmp");
            foreach ($_SESSION['cart'] as $cartItem) {
                //We consider only 3rd and 6th goods. I doubt if anybody will add more than 6 goods to cart
                if ($cartItem->sale != 100 && ($cartItem->goodId == $goods[$size - 1]->id || ($size >= 6 && $cartItem->goodId == $goods[$size - 2]->id))) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 100;
                    $cartItem->price = 1;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                } else if ($cartItem->price == 1 && ($cartItem->goodId != $goods[$size - 1]->id || ($size >= 6 && $cartItem->goodId == $goods[$size - 2]->id))) {
                    $good = $this->registry['model']->getGood($cartItem->goodId);
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                } 
                if ($cartItem->sale != 100) {
                    $cartItem->sale = 1;
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if ($cartItem->price == 1) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }
    
    //Каждый третий товар Мико стоит 1 рубль.
    private function mikoThird() {
        $crystalGoods = [];
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if ($good->firmId == 3) {
                array_push($crystalGoods, $good);
            }
        }
        if (sizeof($crystalGoods) >= 3) {
            function cmp($a, $b) {
                return $a->getPrice() < $b->getPrice();
            }
            usort($crystalGoods, "cmp");
            $size = sizeof($crystalGoods);
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if ($good->firmId == 3) {
                    //We consider only 3rd and 6th goods. I doubt if anybody will add more than 6 Crystall goods to cart
                    if ($good->id == $crystalGoods[$size - 1]->id || ($size >= 6 && $good->id == $crystalGoods[$size - 2]->id)) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->sale = 100;
                        $cartItem->price = 1;
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    } else if ($cartItem->price == 1 && ($good->id != $crystalGoods[$size - 1]->id || ($size >= 6 && $good->id == $crystalGoods[$size - 2]->id))) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->price = $good->getPrice();
                        $cartItem->sale = 0;
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    } 
                    $cartItem->sale = 1;
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if ($good->firmId == 3) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }
    
    //При покупке крема для рук скидка на все 15%
    private function handsCreamDiscount() {
        $discount = false;
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if (in_array(1, $good->cats)) {
                $discount = true;
            }
        }
        if ($discount) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if (!$cartItem->sale){ 
                    if (!in_array(1, $good->cats)) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->sale = 15;
                        $cartItem->price = floor($cartItem->price * (0.85));
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    } else {
                        $cartItem->sale=1;
                    }    
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                if ($cartItem->sale == 15 || $cartItem->sale == 1) {
                    $good = $this->registry['model']->getGood($cartItem->goodId);
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }

    //Каждый второй товар БиоБьюти и Кристалл Декор стоит 1 рубль.
    private function bioBeuatyCDSecond() {
        $saleGoods = [];
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if ($good->firmId == 2 || $good->firmId == 8) {
                array_push($saleGoods, $good);
            }
        }
        if (sizeof($saleGoods) >= 2) {
            function cmp($a, $b) {
                return $a->getPrice() < $b->getPrice();
            }
            usort($saleGoods, "cmp");
            $size = sizeof($saleGoods);
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if ($good->firmId == 2 || $good->firmId == 8) {
                    //We consider only 2nd and 4th goods. I doubt if anybody will add more than 4 goods to cart
                    if ($good->id == $saleGoods[$size - 1]->id || ($size >= 4 && $good->id == $saleGoods[$size - 2]->id)) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->sale = 100;
                        $cartItem->price = 1;
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    } else if ($cartItem->price == 1 && ($good->id != $saleGoods[$size - 1]->id || ($size >= 4 && $good->id == $saleGoods[$size - 2]->id))) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->price = $good->getPrice();
                        $cartItem->sale = 0;
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    } 
                    $cartItem->sale = 1;
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if ($good->firmId == 2 || $good->firmId == 8) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }
    
    //Второй и четвертый товары за полцены
    private function secondHalf() {
        $size = sizeof($_SESSION['cart']);
        if ($size >= 2) {
            $goods = [];
            foreach ($_SESSION['cart'] as $cartItem) {
                array_push($goods, $this->registry['model']->getGood($cartItem->goodId));
            }
            function cmp($a, $b) {
                return $a->getPrice() < $b->getPrice();
            }
            usort($goods, "cmp");
            $salegoods=$goods;
            array_splice($salegoods,0,round($size/2));
            $salegoodids = array();
            foreach ($salegoods as $good) {
                array_push($salegoodids, $good->id);
            }
            foreach ($_SESSION['cart'] as $cartItem) {
                //We consider only 3rd and 6th goods. I doubt if anybody will add more than 6 goods to cart
                if ($cartItem->sale != 50 && in_array($cartItem->goodId, $salegoodids)) { // ($cartItem->goodId == $goods[$size - 1]->id || ($size >= 4 && $size < 6 && $cartItem->goodId == $goods[$size - 2]->id && $cartItem->goodId == $goods[$size - 1]->id) || ($size >= 6 && $cartItem->goodId == $goods[$size - 3]->id && $cartItem->goodId == $goods[$size - 2]->id && $cartItem->goodId == $goods[$size - 1]->id))) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 50;
                    $cartItem->price = floor($cartItem->price * (0.5));;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                } else if ($cartItem->sale == 50 && !in_array($cartItem->goodId, $salegoodids)) {  //($cartItem->goodId != $goods[$size - 1]->id || ($size >= 4 && $size < 6 && $cartItem->goodId != $goods[$size - 2]->id && $cartItem->goodId != $goods[$size - 1]->id) || ($size >= 6 && $cartItem->goodId != $goods[$size - 3]->id && $cartItem->goodId != $goods[$size - 2]->id && $cartItem->goodId != $goods[$size - 1]->id))) {
                    $good = $this->registry['model']->getGood($cartItem->goodId);
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                } 
                if ($cartItem->sale != 50) {
                    $cartItem->sale = 1;
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if ($cartItem->sale == 50) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }

    //При покупке мыла скидка на все 30%
    private function soapDiscount() {
        $discount = false;
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if (in_array(11, $good->cats)) {
                $discount = true;
            }
        }
        if ($discount) {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if (!$cartItem->sale){ 
                    if (!in_array(11, $good->cats)) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->sale = 30;
                        $cartItem->price = floor($cartItem->price * (0.7));
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    } else {
                        $cartItem->sale=1;
                    }    
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                if ($cartItem->sale == 30 || $cartItem->sale == 1) {
                    $good = $this->registry['model']->getGood($cartItem->goodId);
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }
    
    //При покупке любых теней скидка на БиоБьюти и КристаллДекор 30%
    private function shadowDiscount() {
        $discount = false;
        $maxprice = 0;
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if (in_array(41, $good->cats) or in_array(42, $good->cats)) {
                $discount = true;
                $maxprice = max($maxprice, $cartItem->price);
            }
        }
        if ($discount) {
            $this->registry['logger']->lwrite("Max price " . $maxprice);
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if (!$cartItem->sale and ($good->firmId == 2 or $good->firmId == 8)) {
                    if ((in_array(41, $good->cats) or in_array(42, $good->cats)) and $cartItem->price == $maxprice) {
                    } else {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->sale = 30;
                        $cartItem->price = floor($cartItem->price * (0.7));
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    }    
                }
                if ($cartItem->sale == 30 and (in_array(41, $good->cats) or in_array(42, $good->cats)) and $cartItem->price == $maxprice) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if (($good->firmId == 2 or $good->firmId == 8) and $cartItem->sale == 30) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = floor($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }
    
    //При покупке Крисстал Декор тени в подарок.
    private function crystallShadows() {
        $crystalGoods = [];
        $shadows = [];
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if ($good->firmId == 8) {
                array_push($crystalGoods, $good);
            }
            if (in_array(41, $good->cats) or in_array(42, $good->cats)) {
                array_push($shadows, $good);
            }
        }
        if (sizeof($crystalGoods) >= 2 and sizeof($shadows) >=1) {
            function cmp($a, $b) {
                return $a->getPrice() < $b->getPrice();
            }
            usort($shadows, "cmp");
            $size = sizeof($shadows)-1;
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if ((in_array(41, $good->cats) or in_array(42, $good->cats))) {
                    if ($good->id == $shadows[$size]->id) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->sale = 100;
                        $cartItem->price = 1;
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    } else if ($cartItem->price == 1 && $good->id != $shadows[$size]->id) {
                        $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                        $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                        $cartItem->price = $good->getPrice();
                        $cartItem->sale = 0;
                        $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                    }   
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if ((in_array(41, $good->cats) or in_array(42, $good->cats)) and $cartItem->price == 1) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }
    
    //Второй и четвертый товары для дома за полцены
    private function homeSecondHalf() {
        $goods = [];
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            //$this->registry['logger']->lwrite($good->types[0]);
            if (in_array("Для дома", $good->types)) {
                array_push($goods, $good);
            }    
        }
        $size = sizeof($goods);
        $this->registry['logger']->lwrite('Size is '. $size);
        if ($size >= 2) {
            function cmp($a, $b) {
                return $a->getPrice() < $b->getPrice();
            }
            usort($goods, "cmp");
            $salegoods=$goods;
            array_splice($salegoods,0,round($size/2));
            $salegoodids = array();
            foreach ($salegoods as $good) {
                array_push($salegoodids, $good->id);
            }
            foreach ($_SESSION['cart'] as $cartItem) {
                //We consider only 3rd and 6th goods. I doubt if anybody will add more than 6 goods to cart
                if ($cartItem->sale != 50 && in_array($cartItem->goodId, $salegoodids)) { // ($cartItem->goodId == $goods[$size - 1]->id || ($size >= 4 && $size < 6 && $cartItem->goodId == $goods[$size - 2]->id && $cartItem->goodId == $goods[$size - 1]->id) || ($size >= 6 && $cartItem->goodId == $goods[$size - 3]->id && $cartItem->goodId == $goods[$size - 2]->id && $cartItem->goodId == $goods[$size - 1]->id))) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 50;
                    $cartItem->price = floor($cartItem->price * (0.5));;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                } else if ($cartItem->sale == 50 && !in_array($cartItem->goodId, $salegoodids)) {  //($cartItem->goodId != $goods[$size - 1]->id || ($size >= 4 && $size < 6 && $cartItem->goodId != $goods[$size - 2]->id && $cartItem->goodId != $goods[$size - 1]->id) || ($size >= 6 && $cartItem->goodId != $goods[$size - 3]->id && $cartItem->goodId != $goods[$size - 2]->id && $cartItem->goodId != $goods[$size - 1]->id))) {
                    $good = $this->registry['model']->getGood($cartItem->goodId);
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                } 
                if ($cartItem->sale != 50) {
                    $cartItem->sale = 1;
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                $good = $this->registry['model']->getGood($cartItem->goodId);
                if ($cartItem->sale == 50) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = $good->getPrice();
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        }
    }
    
    //Если в корзине товаров на > 2300 рублей, то на все скидка 25%
    private function totalPriceDiscount() {
        if ($this->getCartT(25) >= 2300) {
            foreach ($_SESSION['cart'] as $cartItem) {
                if (!$cartItem->sale) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->sale = 25;
                    $cartItem->price = round($cartItem->price * (0.75));
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
        } else {
            foreach ($_SESSION['cart'] as $cartItem) {
                if ($cartItem->sale == 25) {
                    $this->registry['logger']->lwrite('Updating good ' . $cartItem->goodId);
                    $this->registry['logger']->lwrite('Old price is ' . $cartItem->price);
                    $cartItem->price = round($cartItem->price * 100 / (100 - $cartItem->sale));
                    $cartItem->sale = 0;
                    $this->registry['logger']->lwrite('New price is ' . $cartItem->price);
                }
            }
            
        }
    }
    
    //Если в корзине товаров от Мустаевой больше 1000 рублей, то бесплатно добавляем крем детский
    private function mustaevaCream() {
        $mustaevaTotal = 0;
        foreach ($_SESSION['cart'] as $cartItem) {
            $good = $this->registry['model']->getGood($cartItem->goodId);
            if ($good->id == 677 and $cartItem->price == 1) {
                $already = true;
                break;
            }
            if ($good->id <> 677 && $good->firmId == 1) {
                $mustaevaTotal = $mustaevaTotal + $cartItem->price*$cartItem->quantity;
            }
        }
        $sale = $mustaevaTotal > 1000;
        if (!$already) {
            if ($sale) {
                $cream = new CartItem();
                $cream->goodId = 677;
                $cream->quantity = 1;
                $cream->sizeId = 723;
                $cream->price = 1;
                $cream->sale = 100;
                array_push($_SESSION['cart'], $cream);
            }     
        } else {
            if (!$sale) {
                foreach ($_SESSION['cart'] as $cartItem) {
                    if ($cartItem->goodId == 677 && $cartItem->price == 1) {
                        unset($_SESSION['cart'][array_search($cartItem, $_SESSION['cart'])]);
                        break;
                    }
                }
            } 
        }
    }
    
    private function getCartT($discount) {
        $total = 0;
        foreach ($_SESSION['cart'] as $cartItem) {
            if ($cartItem->sale == $discount) {
                $total = $total + round($cartItem->price * 100 / (100 - $cartItem->sale)) * $cartItem->quantity;
            } else if (!$cartItem->sale) {
                $total = $total + $cartItem->price * $cartItem->quantity;
            }
        }
        return $total;
    }

}