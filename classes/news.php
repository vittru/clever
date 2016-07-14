<?php

Class News {
    
     
    public $header;
    public $time;
    public $text;   
   
    function __construct($header, $time, $text) {
       $this->header = $header;
       $this->time = $time;
       $this->text = $text;
    }

}

