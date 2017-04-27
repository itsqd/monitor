<?php

function debug($message, $exit=true) {
    echo '<pre>';
    print_r($message);
    echo '</pre>';
    
    exit(0);
}


return;