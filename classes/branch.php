<?php

Class Branch {
    
    public $id;
    public $address; 
    public $open;
    public $card;
    public $map;
    
    public function __construct($id, $address, $open, $card, $map) {
        $this->id = $id;
        $this->address = $address;
        $this->open = $open;
        $this->card = $card;
        $this->map = $map;
    }    
    
    public function getShortAddress() {
       return substr($this->address, strpos($this->address, ',')); 
    }    
    
}