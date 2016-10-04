<?php

Class Orderedgood {
     
    public $id;
    public $name;
    public $size;
    public $price;
    public $quantity;
   
    function __construct($id, $name, $size, $price, $quantity) {
        $this->id = $id;
        $this->name = $name;
        $this->size = $size;
        $this->price = $price;
        $this->quantity = $quantity;
    }
}