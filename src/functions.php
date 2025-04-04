<?php
// Sanitize database output

function escape($string) {
  return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

// Redirect

function redirect($location) {
  if(is_numeric($location)) {
    switch($location) {
      case 404:
        header('HTTP/1.0 404 Not Found');

        exit();
      default:
        throw new InvalidArgumentException("Unsupported status code: $location");
      break;
    }
  } else {
    header('Location: ' . $location);

    exit();
  }
}