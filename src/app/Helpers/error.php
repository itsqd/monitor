<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

function app_error_handler($errno, $errmsg, $errfile, $errline)
{
  //if (ini_get('error_reporting')) throw new ErrorException($errmsg, 0, $errno, $errfile, $errline);
  throw new ErrorException("$errmsg", 0, $errno, $errfile, $errline);
}

set_error_handler("app_error_handler", (E_NOTICE | E_WARNING | E_ERROR));
?>
