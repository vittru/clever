<?php


Class Good {
    
    public $id; 
    public $name;
    public $description;
    public $howTo;
    public $madeOf;
    public $sale;
    public $firmId;
    public $cats;
    public $problem;
    public $effs;
    public $skintypes;
    public $hairtypes;
    public $sizes;
    public $types;
   
    function __construct($id, $name, $description, $howTo, $madeOf, $sale, $firmId, $problem) {
       $this->id = $id;
       $this->name = $name;
       $this->description = $description;
       $this->howTo = $howTo;
       $this->madeOf = $madeOf;
       $this->sale = $sale;
       $this->firmId = $firmId;
       $this->problem = $problem;
    }
    
    function getPrice() {
        return reset($this->sizes)->price * (100-$this->sale)/100;
    }
    
    function getOldPrice() {
        return reset($this->sizes)->price;
    }
    
}

