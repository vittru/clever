<?php


Class Firm {
    
    public $id; 
    public $name;
    public $description;
    public $goods;
    public $categories;
    public $url;

    function __construct($id, $name, $description, $url) {
       $this->id = $id;
       $this->name = $name;
       $this->description = $description;
       $this->url = $url;
    }
    
}

