<?php

Class Orderedgood {
     
    public $id;
    public $name;
    public $size;
    public $price;
    public $quantity;
    public $code;
    public $sale;
   
    function __construct($id, $name, $size, $price, $quantity, $code, $sale) {
        $this->id = $id;
        $this->name = $name;
        $this->size = $size;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->code = $code;
        $this->sale = $sale;
    }
}