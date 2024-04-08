<?php
include 'config.php';
class DAO extends Config{

    public $condb;
    
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
        $stmt = $this->condb->prepare("SELECT id_utilisateur FROM users WHERE email = ?");
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

    public function insert_into($tableName, $array, $size, $primaryKey){
        $string = "INSERT INTO " . $tableName . " (";
        foreach ($array as $key => $value) {
            $string .= $value . ",";
        }
        $string = rtrim($string, ","); // Remove trailing comma
    
        $string .= ") SELECT ";
    
        for ($i = 0; $i < $size; $i++) {
            $string .= "?,";
        }
        $string = rtrim($string, ","); // Remove trailing comma
    
        $string .= " WHERE NOT EXISTS (SELECT 1 FROM " . $tableName . " WHERE " . $primaryKey . " = ?)";
        return $string;
    }
}