<?php

Class Orderedgood {
     
    public $id;
    public $name;
    public $size;
    public $price;
    public $quantity;
    public $code;
    public $sale;
    public $sizeId;
   
    function __construct($id, $name, $size, $price, $quantity, $code, $sale, $sizeId) {
        $this->id = $id;
        $this->name = $name;
        $this->size = $size;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->code = $code;
        $this->sale = $sale;
        $this->sizeId = $sizeId;
    }
}