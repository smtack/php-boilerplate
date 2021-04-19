<?php
require_once "config.php";

spl_autoload_register(function($class) {
  include_once "classes/" . $class . ".php";
});

$database = new Database();
$db = $database->DB();

session_start();