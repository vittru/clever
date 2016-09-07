<?php

Class News {
    
     
    public $header;
    public $time;
    public $text; 
    private $id;
   
    function __construct($id, $header, $time, $text) {
        $this->id = $id;
        $this->header = $header;
        setlocale(LC_TIME, "ru_RU.UTF-8");
        $this->time = strftime('%e/%m/%G', strtotime($time));
        $this->text = $text;
    }
    
    function getWebText() {
        $property = $this->text;
        foreach (array("\r", "\n", "\r\n", "\n\r") as $token) {
            $property = str_replace($token, "</p><p>",  $property);
        }
        return "<div>" . $property . "</div>";    
    }  
    
    function getImage() {
        $file_name = 'images/news/news' . $this->id;
        if (!file_exists($file_name . '.jpg')) {
            if (!file_exists($file_name . '.png')) {
                $file_name = 'images/news/news0.png';
            } else {
                $file_name = $file_name . '.png';
            }    
        } else {
            $file_name = $file_name . '.jpg';
        }
        return '/'.$file_name;
    }    

}

