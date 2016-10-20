<?php

Class Order {
     
    public $id;
    public $date;
    public $status;
    public $statusdesc;
    public $type;
    public $promo;
    public $user;
    public $profile;
    public $total;
    public $goods;
   
    function __construct($id, $date, $status, $type, $promo, $user, $profile, $statusdesc) {
        $this->id = $id;
        $this->status = $status;
        setlocale(LC_TIME, "ru_RU.UTF-8");
        $this->date = strftime('%e/%m/%G', strtotime($date));
        $this->type = $type;
        $this->promo = $promo;
        $this->user = $user;
        $this->profile = $profile;
        $this->statusdesc = $statusdesc;
    }
}