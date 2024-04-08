<?php

require 'models/connectionUser.php';
include 'models/user.php';
include_once 'config.php';

class userController {

    private $conn;
    protected $userModel;
    public function __construct() {
        $this->userModel = new userModel(new config());
    }

    

    public function userHandler($obj) {
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
                $user=$this->selectRecord($obj);
                break;
            case 'DELETE':
                $obj=new User($_POST['email'],"","","","");
                break;
            case 'UPDATE':
                $obj = new User($_POST['email'],$_POST['password'],$_POST['surname'],$_POST['type'],$_POST['name']);
                $user=$this->updateRecord($obj);
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
            $this->userModel->open_db();
            $query=$this->userModel->prepare("INSERT INTO users (name, email, password, surname, type) 
SELECT ?, ?, ?, ?, ?
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = ?)");
            if (!$query) {
                throw new Exception("Erreur de préparation de la requête: " . $this->userModel->condb->error);
            }
            $query->bind_param("ssssss", $obj->name, $obj->email, $obj->password, $obj->surname, $obj->type, $obj->email); 
            $query->execute();
            $res= $query->get_result();
            $last_id=$this->userModel->insert_id($obj);
            $query->close();
            $this->userModel->close_db();
            return $last_id;
        }
        catch (Exception $e)
        {
            $this->userModel->close_db();
            throw $e;
        }
    }
    //get id
    
    public function updateRecord($obj)
    {
        try
        {
            $id=$this->userModel->insert_id($obj);
            $this->userModel->open_db();
            $query = $this->userModel->prepare("UPDATE users SET name = IFNULL(?, name), email = IFNULL(?, email), password = IFNULL(?, password), surname = IFNULL(?, surname), type = IFNULL(?, type) WHERE id = ?");            
            $query->bind_param("sssssi", $obj->name, $obj->email, $obj->password, $obj->surname, $obj->type,$id);
            $query->execute();
            $res=$query->get_result();
            $query->close();
            $this->userModel->close_db();
            return true;
        }
        catch (Exception $e)
        {
            $this->userModel->close_db();
            throw $e;
        }
    }
    // delete record
    public function deleteRecord($obj)
    {
        try{
            $id=$this->userModel->insert_id($obj);
            $this->userModel->open_db();
            $query=$this->userModel->prepare("DELETE FROM users WHERE id=?");
            $query->bind_param("i",$id);
            $query->execute();
            $query->get_result();
            $query->close();
            $this->userModel->close_db();
            return true;
        }
        catch (Exception $e)
        {
            $this->userModel->close_db();
            throw $e;
        }
    }
    // select record
    public function selectRecord($obj)
    {
        try
        {
            $this->userModel->open_db();
            $id=$this->userModel->insert_id($obj);
 
            $query=$this->userModel->prepare("SELECT * FROM users WHERE id=?");
            $query->bind_param("i",$id);
            $query->execute();
            $res=$query->get_result();
            $query->close();
            $this->userModel->close_db();
            return $res;
        }
        catch(Exception $e)
        {
            $this->userModel->close_db();
            throw $e;
        }
    }
}