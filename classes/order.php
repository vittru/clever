<?php

Class Order {
     
    public $id;
    public $date;
    public $status;
    public $statusdesc;
    public $type;
    public $promo;
    public $user;
    public $email;
    public $profile;
    public $total;
    public $goods;
    public $bonus;
    public $username;
    public $phone;
    public $remarks;
    public $address;
   
    function __construct($id, $date, $status, $type, $promo, $user, $profile, $statusdesc, $email, $bonus, $username, $phone, $remarks, $address) {
        $this->id = $id;
        $this->status = $status;
        setlocale(LC_TIME, "ru_RU.UTF-8");
        $this->date = $date;
        $this->type = $type;
        $this->promo = $promo;
        $this->user = $user;
        $this->profile = $profile;
        $this->statusdesc = $statusdesc;
        $this->email = $email;
        $this->bonus = $bonus;
        $this->username = $username;
        $this->phone = $phone;
        $this->remarks = $remarks;
        $this->address = $address;
    }
    
    function getTotalNoSale() {
        $total = 0;
        foreach ($this->goods as $good) {
            if (!$good->sale) {
                $total = $total + $good->quantity * $good->price;
            }
        }
        return $total;
    }
    
    function getTotal() {
        $total = 0;
        foreach ($this->goods as $good) {
            $total = $total + $good->quantity * $good->price;
        }
        return $total;
    }
}