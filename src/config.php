<?php
class Config
{
    public $host;
    public $user;
    public $pass;
    public $db;
    function __construct() {
        $this->host = "localhost:33061";
        $this->user  = "root";
        $this->pass = "root";
        $this->db = "mydb13";
    }
}
