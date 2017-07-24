<?php

Class Category {
    
    public $id; 
    public $name;
    public $description;
    public $url;
    public $goods;
    public $metaTitle;
    public $metaDescription;

    function __construct($id, $name, $description, $url, $metaTitle, $metaDescription) {
       $this->id = $id;
       $this->name = $name;
       $this->description = $description;
       $this->url = $url;
       $this->metaTitle = $metaTitle;
       $this->metaDescription = $metaDescription;
    }    
}

