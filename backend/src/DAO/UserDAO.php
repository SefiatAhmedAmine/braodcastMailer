<?php

// require_once($_SERVER['DOCUMENT_ROOT']. '/monasaba/backend/src/DAO/DB.php');

require_once(__DIR__ . '/DB.php');

class UserDAO {
  protected $conn;
  protected $table = "users";
  protected $fillable = ["firstname", "lastname", "sexe", "email"];
  protected $hidden = ["password"];

  public function __construct()
  {  
    $dbInstance = DB::getInstance();
    $this->conn = $dbInstance->getConnection();
  }

  public function getFirstnameCol()
  {
    return $this->fillable[0];
  }
  public function getLastnameCol()
  {
    return $this->fillable[1];
  }
  public function getEmailCol()
  {
    return $this->fillable[3];
  }
  public function getPasswordCol()
  {
    return $this->hidden[0];
  }
  /**
   * return name and email of all USER table records 
   *
   * @return array{}
   */
  public function all(){
    $cols = implode(",", $this->fillable) . "," . implode($this->hidden);
    $sql = $this->conn->prepare("SELECT $cols FROM $this->table");
    $sql->execute();
    return $sql->fetchAll();
  }


  public function getUserWithEmail($email){
    $emailCol = $this->getEmailCol();
    $cols = implode(",", $this->fillable) . "," . implode($this->hidden);
    $sql = $this->conn->prepare("SELECT $cols FROM $this->table
      WHERE $emailCol = ?");
    $sql->execute([$email]);
    return $sql->fetch();
  }

  /**
   * Undocumented function
   *
   * @param array $data
   * @return void
   */
  public function store($data = [])
  {
    $cols = implode(",", $this->fillable) . "," . implode($this->hidden);
    $sql = $this->conn->prepare("Insert into $this->table ($cols)
    value (:nom, :prenom, :sexe, :email, :password)");
    try {
      $sql->execute($data);
    } catch (\Throwable $th) {
      echo "Error Processing Insert Request";
      return false;
    }
    return true;
  }

}
