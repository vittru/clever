<?php

Class Order {
     
    public $id;
    public $date;
    public $status;
    public $type;
    public $promo;
   
    function __construct($id, $date, $status, $type, $promo) {
        $this->id = $id;
        $this->status = $status;
        setlocale(LC_TIME, "ru_RU.UTF-8");
        $this->date = strftime('%e/%m/%G', strtotime($date));
        $this->type = $type;
        $this->promo = $promo;
    }
}