<?php

class Size {
    public $id;
    public $size;
    public $price;
    public $sale;
    public $code;
    public $instock;
    public $onhold;
    
    public function __construct($id, $size, $price, $sale, $code, $instock, $onhold) {
        $this->id = $id;
        $this->size = $size;
        $this->price = $price;
        $this->sale = $sale;
        $this->code = $code;
        $this->instock = $instock;
        $this->onhold = $onhold;
    }
    
    public function getPrice($sale) {
        return ($this->price * (100-$sale)/100) . " руб.";
    }
    
    public function isAvailable() {
        return (($this->instock - $this->onhold) > 0);
    }
}
