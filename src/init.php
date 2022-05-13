<?php
require_once "config.php";

spl_autoload_register(function($class) {
  include_once "classes/" . $class . ".php";
});

session_start();

$db = new Database();