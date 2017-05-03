<?php

function debug($message, $exit=false) {
    echo '<pre>';
    print_r($message);
    echo '</pre>';
    
    if ($exit)
        exit(0);
}


return;