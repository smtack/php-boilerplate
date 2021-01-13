<?php
require_once "config.php";

$dbhost = DB_HOST;
$dbname = DB_NAME;
$dbuser = DB_USER;
$dbpass = DB_PASS;
$dbchar = DB_CHARSET;

$dsn = "mysql:host=$dbhost;dbname=$dbname;charset=$dbchar";

$opt = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false
];

try {
  $db = new PDO($dsn, $dbuser, $dbpass, $opt);
} catch (PDOException $e) {
  echo "Could not connect to the Database: " . $e->getMessage();
}
?>