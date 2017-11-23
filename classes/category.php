<?php

Class Category {
    
    public $id; 
    public $name;
    public $description;
    public $url;
    public $goods;
    public $metaTitle;
    public $metaDescription;
    public $metaKeywords;
    public $supercatId;
    public $descAfter;

    function __construct($id, $name, $description, $url, $metaTitle, $metaDescription, $metaKeywords, $supercatId, $descAfter) {
       $this->id = $id;
       $this->name = $name;
       $this->description = $description;
       $this->url = $url;
       $this->metaTitle = $metaTitle;
       $this->metaDescription = $metaDescription;
       $this->metaKeywords = $metaKeywords;
       $this->supercatId = $supercatId;
       $this->descAfter = $descAfter;
    }    
}

