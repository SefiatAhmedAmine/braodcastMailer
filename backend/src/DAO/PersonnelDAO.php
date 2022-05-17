<?php

// require_once($_SERVER['DOCUMENT_ROOT']. '/monasaba/backend/src/DAO/DB.php');

require_once(__DIR__ . '/DB.php');

class PersonnelDAO {
  protected $conn;
  protected $table = "personnelanniw";
  protected $fillable = ["prenom", "nom", "email", "sexe", "date_naiss", "date_rec"];
  protected $hidden = [];

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
    return $this->fillable[2];
  }
  public function getSexeCol()
  {
    return $this->fillable[3];
  }
  public function getBirthCol()
  {
    return $this->fillable[4];
  }
  public function getRecrutementCol()
  {
    return $this->fillable[5];
  }
  /**
   * return name and email of all USER table records 
   *
   * @return array{}
   */
  public function all(){
    $cols = 'nom, sexe';
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


}
