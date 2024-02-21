<?php

include 'models/connectionUser.php';
include 'models/user.php';
include_once 'config.php';

class userController {

    private $conn;

    public function __construct() {
        $this->conn = new userModel(new config());
    }

    public function userHandler() {
        // Récupérer l'action de l'utilisateur depuis la requête
        $action = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'default';
    
        // Exécuter le traitement approprié en fonction de l'action
        switch ($action) {
            case 'POST':
                $obj = new User($_POST['email'],$_POST['password'],$_POST['surname'],$_POST['type'],$_POST['name']); 
                // Instancier un objet avec les données nécessaires
                $last_id = $this->insertRecord($obj);
                // Autres actions ou retours en fonction des besoins
                break;
            // Autres cas pour d'autres actions
            case 'GET':
                $obj=new User($_POST['email'],"","","","");
                $user=selectRecord($obj);
                break;
            case 'DELETE':
                $obj=new User($_POST['email'],"","","","");
                break;
            case 'UPDATE':
                $obj = new User($_POST['email'],$_POST['password'],$_POST['surname'],$_POST['type'],$_POST['name']);
                updateRecord($obj);
                break;
            default:
                echo("error");
                break;
        }
    }
    
    // insert record
    public function insertRecord($obj)
    {
        try
        {
            $this->conn->open_db();
            $query=$this->condb->prepare("INSERT INTO users (name, email, password, surname, type, email) VALUES (?, ?, ?, ?, ? IF NOT EXISTS ?)");
            if (!$query) {
                throw new Exception("Erreur de préparation de la requête: " . $this->condb->error);
            }
            $query->bind_param("sssss", $obj->name, $obj->email, $obj->password, $obj->surname, $obj->type); 
            $query->execute();
            $res= $query->get_result();
            $last_id=$this->condb->insert_id;
            $query->close();
            $this->close_db();
            return $last_id;
        }
        catch (Exception $e)
        {
            $this->conn->close_db();
            throw $e;
        }
    }
    //get id
    public function get_id($obj){
        try{
        $query=$this->condb->prepare("SELECT id WHERE email=?");
        $query->bind_param("s",$obj->email);
        $query->execute();
        $id=$query->get_result();
        $query->close();
        $this->close_db();
        return $id;
        }
        catch (Exception $e)
        {
            $this->close_db();
            throw $e;
        }
    }

    //update record
    public function updateRecord($obj)
    {
        try
        {
            $id=get_id($obj);
            $this->open_db();
            $query=$this->condb->prepare("UPDATE users SET name=?, email=?, password=?, surname=?, type=? WHERE id=?");
            //s'assurer que les champs ne sont pas mis à null par la query
            $query->bind_param("sssssi", $obj->name, $obj->email, $obj->password, $obj->surname, $obj->type,$id);
            $query->execute();
            $res=$query->get_result();
            $query->close();
            $this->close_db();
            return true;
        }
        catch (Exception $e)
        {
            $this->close_db();
            throw $e;
        }
    }
    // delete record
    public function deleteRecord($obj)
    {
        try{
            $id=get_id($obj);
            $this->open_db();
            $query=$this->condb->prepare("DELETE FROM users WHERE id=?");
            $query->bind_param("i",$id);
            $query->execute();
            $res=$query->get_result();
            $query->close();
            $this->close_db();
            return true;
        }
        catch (Exception $e)
        {
            $this->closeDb();
            throw $e;
        }
    }
    // select record
    public function selectRecord($obj)
    {
        try
        {
            $id=get_id($obj);
            $this->open_db();
            $query=$this->condb->prepare("SELECT * FROM users WHERE id=?");
            $query->bind_param("i",$id);
            $query->execute();
            $res=$query->get_result();
            $query->close();
            $this->close_db();
            return $res;
        }
        catch(Exception $e)
        {
            $this->close_db();
            throw $e;
        }
    }
} 