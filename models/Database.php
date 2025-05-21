<?php

class Database
{
  private $host = 'localhost';
  private $user = 'root';
  private $password = 'root';
  private $dbname = 'g1_academy';
  private $conn;

  public function __construct()
  {
    try {
      $db = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";
      $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_PERSISTENT => false
      ];
      $this->conn = new PDO($db, $this->user, $this->password, $options);
    } catch (PDOException $e) {
      echo '(!) Connection failed: ' . $e->getMessage();
    }
  }

  public function setConnection($conn)
  {
    $this->conn = $conn;
  }

  public function getConnection()
  {
    return $this->conn;
  }

  public function destruct()
  {
    $this->conn = null;
  }
}
