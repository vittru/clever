<?php


Class Firm {
    
    public $id; 
    public $name;
    public $description;
    public $goods;
    public $categories;

    function __construct($id, $name, $description) {
       $this->id = $id;
       $this->name = $name;
       $this->description = $description;
    }
    
}

