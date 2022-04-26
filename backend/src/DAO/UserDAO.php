<?php

require_once($_SERVER['DOCUMENT_ROOT']. '/backend/src/DAO/DB.php');

class UserDAO {
  protected $conn;
  protected $table = "users";
  protected $name = "name";
  protected $email = "email";

  public function __construct()
  {  
    $dbInstance = DB::getInstance();
    $this->conn = $dbInstance->getConnection();
  }
  
  public function getName()
  {
    return $this->name;
  }

  public function getEmail()
  {
    return $this->email;
  }
  /**
   * return name and email of all USER table records 
   *
   * @return array{}
   */
  public function all(){
    $sql = $this->conn->prepare("SELECT $this->name, $this->email FROM $this->table");
    $sql->execute();
    return $sql->fetchAll();
  }

}
