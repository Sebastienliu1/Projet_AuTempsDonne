<?php
include 'config.php';
class userModel
{
    private $host;
    private $user;
    private $pass;
    private $db;
    public $condb;
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
    
        $this->condb = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->condb->connect_error) {
            die("Erron in connection: " . $this->condb->connect_error);
        }
    }

    //prepare statement
    public function prepare($sql_request)
    {
        if ($this->condb) {
            $stmt = $this->condb->prepare($sql_request);
            if (!$stmt) {
                die("Error in preparing statement: " . $this->condb->error);
            }
            return $stmt;
        } else {
            die("prepare::Database connection not established.");
        }
    }

public function insert_id($user){
    if ($this->condb) {
        $stmt = $this->condb->prepare("SELECT id WHERE email=?");
    } else {
        die("prepare::Database connection not established.");
    }
    $stmt->bind_param("s",$user->email);
    $stmt->execute();
    $id=$stmt->get_result();
    $stmt->close();
    if ($this->condb !== null) {
        $this->condb->close();
        $this->condb = null;
    }
    return $id;
}

    // close database
    public function close_db()
    {
        if ($this->condb !== null) {
            $this->condb->close();
            $this->condb = null;
        }
    }
}
