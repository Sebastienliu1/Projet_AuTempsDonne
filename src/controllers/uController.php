<?php

require 'models/cUser.php';
include 'models/user.php';

class userController {

protected $userModel;
public function __construct() {
    $this->userModel = new userModel(new DAO());
}

public function userHandler($obj) {
    $action = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'default';
    $data = json_decode($obj, true);
    switch ($action) {
        case 'POST':
            $obj = new User($data['name'],$data['email'],$data['password'],$data['surname'],$data['type']); 
            // Instancier un objet avec les données nécessaires
            $last_id = $this->userModel->insertRecord($obj);
            // Autres actions ou retours en fonction des besoins
            break;
        // Autres cas pour d'autres actions
        case 'GET':
            $obj=new User($data['email'],"","","","");
            $user=$this->selectRecord($obj);
            break;
        case 'DELETE':
            $obj=new User($data['email'],"","","","");
            break;
        case 'UPDATE':
            $obj = new User($data['email'],$data['password'],$data['surname'],$data['type'],$data['name']);
            
            $user=$this->updateRecord($obj);
            break;
        default:
            echo("error");
            break;
        }
    }
}