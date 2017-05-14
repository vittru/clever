<?php

Class Blog {
    
     
    public $id;
    public $name;
    public $author;
    public $url; 
    public $text;
    public $date;
   
    function __construct($id, $name, $author, $url, $text, $date) {
        $this->id = $id;
        $this->name = $name;
        setlocale(LC_TIME, "ru_RU.UTF-8");
        $this->date = strftime('%e.%m.%G', strtotime($date));
        $this->text = $text;
        $this->author = $author;
        $this->url = $url;
    }
    
    function getImage() {
        $file_name = 'images/blogs/blog' . $this->id;
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