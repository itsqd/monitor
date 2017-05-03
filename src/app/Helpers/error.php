<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

function app_error_handler($errno, $errmsg, $errfile, $errline)
{
    echo '<h1>Ooooopppss!!!!!</h1></br>';
    echo '<pre>' . $errno . ' - ' . $errmsg . ' - ' . $errfile . ' - ' . $errline .'</pre>';
    exit(0);
    
}


/**
 * 
 * @param type $module
 * @param type $message
 * @param type $function
 * @param type $class
 * @param type $detail
 */
function jsonErrorReturn($module, $message, $function = '',$class='', $detail='') {
    
    header('Content-Type: application/json');
    echo json_encode([
        'module' => $module,
        'message' => $message,
        'class' => $class,
        'function' => $function,
        'detail' => $detail,
    ]);
    
    exit(0);
    
}



set_error_handler("app_error_handler", (E_NOTICE | E_WARNING | E_ERROR));


?>
