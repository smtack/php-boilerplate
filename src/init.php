<?php
require_once "config.php";
require_once "functions.php";

spl_autoload_register(function($class) {
  include_once "classes/" . $class . ".php";
});

$db = new Database();