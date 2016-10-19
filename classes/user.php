<?php

class User {
    public $id;
    public $lastvisit;
    public $name;
    public $email;
    public $phone;
    public $client;
    public $spam;
    public $password;
    public $bonus;
    public $orders;

    public function __construct($userId) {
        $this->id = $userId;
    }
}
