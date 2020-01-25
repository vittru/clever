<?php

class Size {
    public $id;
    public $size;
    public $price;
    public $sale;
    public $code;
    public $instock;
    public $onhold;
    public $bestbefore;
    public $bbprice;
    
    public function __construct($id, $size, $price, $sale, $code, $instock, $onhold, $bestbefore, $bbprice) {
        $this->id = $id;
        $this->size = str_replace(" ", "&nbsp;", $size);
        $this->price = $price;
        $this->sale = $sale;
        $this->code = $code;
        $this->instock = $instock;
        $this->onhold = $onhold;
        $this->bestbefore = $bestbefore;
        $this->bbprice = $bbprice;
    }
    
    public function getPrice($sale) {
        return floor($this->price * (100-$sale)/100);
    }
    
    public function getWebPrice($sale) {
        return $this->getPrice($sale) . currency;
    }
    
    public function isAvailable() {
        return (($this->instock - $this->onhold) > 0);
    }
    
    public function isBB() {
        return $this->bestbefore;
    }
    
    public function getWebBBPrice() {
        return $this->bbprice . currency;
    }
    
}
