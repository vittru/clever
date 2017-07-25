<?php


Class Firm {
    
    public $id; 
    public $name;
    public $description;
    public $goods;
    public $categories;
    public $url;
    public $metaTitle;
    public $metaDescription;
    public $metaKeywords;
    public $descAfter;
    public $h1;

    function __construct($id, $name, $description, $url, $metaTitle, $metaDescription, $metaKeywords, $descAfter, $h1) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->url = $url;
        $this->metaTitle = $metaTitle;
        $this->metaDescription = $metaDescription;
        $this->metaKeywords = $metaKeywords;
        $this->descAfter = $descAfter;
        $this->h1 = $h1;
    }
    
}

