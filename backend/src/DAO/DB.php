<?php
class DB
{

  /**
   * the server name
   *
   * @var string
   */
  //private $servername = "localhost";
  private $servername = "omranecoxvprosol.mysql.db";
  
  /**
   * the name of the database
   *
   * @var string
   */
  //private $dbname = "test";
  private $dbname = "omranecoxvprosol";
  
  /**
   * database credentials
   *
   * @var string
   */
  //private $username = "root";
  //private $password = "";
  private $username = "omranecoxvprosol";
  private $password = "Prosol17";

  /**
   * the singleton object
   *
   * @var [DB]
   */
  private static $instance = null;
  /**
   * PDO connexion to the database
   *
   * @var [PDO]
   */
  private $conn;
   

  // La connexion au bd est établie dans le constructeur privé.
  private function __construct()
  {
    $this->conn = new PDO("mysql:host=$this->servername; dbname=$this->dbname", $this->username, $this->password);
  }
  

  /**
   * methode qui crée l'unique instance de la classe
   *
   * @return DB
   */
  public static function getInstance()
  {
    if(!self::$instance)
    {
      self::$instance = new DB();
    }
   
    return self::$instance;
  }
  

  /**
   * retourne la connexion avec la base de données
   *
   * @return PDO
   */
  public function getConnection()
  {
    return $this->conn;
  }

  public function getDbName(){
    return $this->dbname;
  }


}
