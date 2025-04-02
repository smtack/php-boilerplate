<?php
class Database {
  private $dbhost = DB_HOST;
  private $dbname = DB_NAME;
  private $dbuser = DB_USER;
  private $dbpass = DB_PASSWORD;
  private $dbchar = DB_CHARSET;

  public $pdo;
  public $dsn;
  public $opt;

  public function __construct() {
    $this->pdo = null;

    $this->dsn = "mysql:host=" . $this->dbhost . ";dbname=" . $this->dbname . ";charset=" . $this->dbchar;

    $this->opt = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      PDO::ATTR_EMULATE_PREPARES => false
    ];

    try {
      $this->pdo = new PDO($this->dsn, $this->dbuser, $this->dbpass, $this->opt);
    } catch(\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    return $this->pdo;
  }

  public function insert($table, $array) {
    $sql = "INSERT INTO " . $table . " (";
    $pref = "";

    foreach($array as $key => $value) {
      $sql .= $pref . $key;
      $pref = ", ";
    }

    $sql .= ") VALUES (";
    $pref = "";

    foreach($array as $key => $value) {
      $sql .= $pref . ":" . $key;
      $pref = ", ";
    }

    $sql .= ")";

    $stmt = $this->pdo->prepare($sql);

    foreach($array as $key => $value) {
      $stmt->bindValue(":$key", $value);
    }

    try {
      $stmt->execute();
    } catch(\PDOException $e) {
      error_log("Error: " . $e->getMessage() . "Code: " . $e->getCode());
      throw new Exception("An error occurred");
    }

    return $stmt;
  }

  public function select($table, $array) {
    $sql = "SELECT * FROM " . $table;
    $pref = " WHERE ";

    foreach($array as $key => $value) {
      $sql .= $pref . $key . "=:" . $key;
      $pref = " AND ";
    }

    $stmt = $this->pdo->prepare($sql);

    foreach($array as $key => $value) {
      $stmt->bindValue(":$key", $value);
    }

    try {
      $stmt->execute();
    } catch(\PDOException $e) {
      error_log("Error: " . $e->getMessage() . "Code: " . $e->getCode());
      throw new Exception("An error occurred");
    }

    return $stmt;
  }

  public function update($table, $array, $field) {
    $sql = "UPDATE " . $table . " SET ";
    $pref = "";

    foreach($array as $key => $value) {
      $sql .= $pref . $key . "=:set_" . $key;
      $pref = ", ";
    }

    $sql .= " WHERE ";
    $pref = "";

    foreach($field as $key => $value) {
      $sql .= $pref . $key . "=:where_" . $key;
      $pref = " AND ";
    }

    $stmt = $this->pdo->prepare($sql);

    foreach($array as $key => $value) {
      $stmt->bindValue(":set_$key", $value);
    }

    foreach($field as $key => $value) {
      $stmt->bindValue(":where_$key", $value);
    }

    try {
      $stmt->execute();
    } catch(\PDOException $e) {
      error_log("Error: " . $e->getMessage() . "Code: " . $e->getCode());
      throw new Exception("An error occurred");
    }

    return $stmt;
  }

  public function delete($table, $array) {
    $sql = "DELETE FROM " . $table;
    $pref = " WHERE ";

    foreach($array as $key => $value) {
      $sql .= $pref . $key . "=:" . $key;
      $pref = " AND ";
    }

    $stmt = $this->pdo->prepare($sql);

    foreach($array as $key => $value) {
      $stmt->bindValue(":$key", $value);
    }

    try {
      $stmt->execute();
    } catch(\PDOException $e) {
      error_log("Error: " . $e->getMessage() . "Code: " . $e->getCode());
      throw new Exception("An error occurred");
    }

    return $stmt;
  }

  public function exists($table, $array) {
    $stmt = $this->select($table, $array);

    return $stmt->rowCount() > 0;
  }
}