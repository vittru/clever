<?php

Class Category {
    
    public $id; 
    public $name;
    public $description;
    public $url;
    public $goods;

    function __construct($id, $name, $description, $url) {
       $this->id = $id;
       $this->name = $name;
       $this->description = $description;
       $this->url = $url;
    }    
}

