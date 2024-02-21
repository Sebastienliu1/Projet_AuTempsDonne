<?php
include 'config.php';
class userModel{
    private $host;
    private $user;
    private $pass;
    private $db;
    private $condb;
function __construct($consetup)
    {
        $this->host = $consetup->host;
        $this->user = $consetup->user;
        $this->pass =  $consetup->pass;
        $this->db = $consetup->db;
    }
    // open mysql data base
    public function open_db()
    {
        $this->condb=new mysqli($this->host,$this->user,$this->pass,$this->db);
        echo("<p>db ok</p>");
        if ($this->condb->connect_error)
        {
            die("Erron in connection: " . $this->condb->connect_error);
            echo("<p>error</p>");
        }
    }
    // close database
    public function close_db()
    {
        if ($this->condb !== null) {
            $this->condb->close();
        }
    }
}

?>