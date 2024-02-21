<?php
class User {
    public $name;
    public $email;
    public $password;
    public $surname;
    public $type;


    function __construct($name, $email, $password, $surname, $type) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->surname = $surname;
        $this->type = $type;
    }
} ?>