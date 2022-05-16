<?php

// require_once($_SERVER['DOCUMENT_ROOT']. '/monasaba/backend/src/DAO/DB.php');

require_once(__DIR__ . '/DB.php');

class LogsDAO {
  protected $conn;
  protected $table = "logs";
  protected $fillable = ["expeditor", "subject", "send_at"];

  public function __construct()
  {  
    $dbInstance = DB::getInstance();
    $this->conn = $dbInstance->getConnection();
  }

  /**
   * Undocumented function
   *
   * @param array $data
   * @return void
   */
  public function store($data = [])
  {
    $cols = implode(",", $this->fillable) ;
    $sql = $this->conn->prepare("Insert into $this->table ($cols)
    value (:expeditor, :subject, :send_at)");
    try {
      $sql->execute($data);
    } catch (\Throwable $th) {
      throw new Exception("Error Processing Insert Request", 1);
    }
    return $data;
  }

}
