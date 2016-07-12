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
    public $probs;
    public $effs;
    public $skintypes;
    public $hairtypes;
   
    function __construct($id, $name, $description, $howTo, $madeOf, $sale, $firmId) {
       $this->id = $id;
       $this->name = $name;
       $this->description = $description;
       $this->howTo = $howTo;
       $this->madeOf = $madeOf;
       $this->sale = $sale;
       $this->firmId = $firmId;
    }
    
}

