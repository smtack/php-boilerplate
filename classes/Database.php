<?php
class Database {
  private $dbhost = DB_HOST;
  private $dbname = DB_NAME;
  private $dbuser = DB_USER;
  private $dbpassword = DB_PASSWORD;
  private $dbcharset = DB_CHARSET;

  public $db;
  public $dsn;
  public $options;

  public function DB() {
    $this->db = null;

    $this->dsn = "mysql:host=" . $this->dbhost . ";dbname=" . $this->dbname . ";charset=" . $this->dbcharset;

    $this->options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false
    ];

    try {
      $this->db = new PDO($this->dsn, $this->dbuser, $this->dbpassword, $this->options);
    } catch(PDOException $e) {
      die($e->getMessage());
    }

    return $this->db;
  }
}