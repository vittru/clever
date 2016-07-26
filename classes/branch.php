<?php

Class Branch {
    
    public $id;
    public $address; 
    public $open;
    public $card;
    
    public function __construct($id, $address, $open, $card) {
        $this->id = $id;
        $this->address = $address;
        $this->open = $open;
        $this->card = $card;
    }    
    
}