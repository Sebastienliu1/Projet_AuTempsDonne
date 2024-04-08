<?php
require 'DAO.php';
class userModel extends DAO
{ 
    public function insertRecord($obj)
    {
        try
        {
            $this->open_db();
            $items = [];
            $size=0;
            $DAO = new DAO();
            foreach ($obj as $k => $v){
                $size = array_push($items, $k);
            }
            print_r($items);
            print_r($obj);
            $string = $DAO->insert_into("users", $items, $size, "email");
            print_r($string);
            $query=$this->prepare($string);
            if (!$query) {
                throw new Exception("Erreur de préparation de la requête: " . $this->condb->error);
            }
            $query->bind_param("ssssss", $obj->name, $obj->email, $obj->password, $obj->surname, $obj->type, $obj->email); 
            $query->execute();
            $res= $query->get_result();
            $last_id=$this->insert_id($obj);
            $query->close();
            $this->close_db();
            return $last_id;
        }
        catch (Exception $e)
        {
            $this->close_db();
            throw $e;
        }
    }
    //get id
    
    public function updateRecord($obj)
    {
        try
        {
            $id=$this->insert_id($obj);
            $this->open_db();
            $query = $this->prepare("UPDATE users SET name = IFNULL(?, name), email = IFNULL(?, email),
            password = IFNULL(?, password), surname = IFNULL(?, surname), type = IFNULL(?, type) WHERE id = ?");            
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
            $id=$this->insert_id($obj);
            $this->open_db();
            $query=$this->prepare("DELETE FROM users WHERE id=?");
            $query->bind_param("i",$id);
            $query->execute();
            $query->get_result();
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
    // select record
    public function selectRecord($obj)
    {
        try
        {
            $this->open_db();
            $id=$this->insert_id($obj);
 
            $query=$this->prepare("SELECT * FROM users WHERE id=?");
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
