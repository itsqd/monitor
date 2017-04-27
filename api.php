<?php

require_once 'api/Listener.php';
require_once 'src/Database.php';
require 'src/hooks.php';
require 'src/error.php';
require 'src/response.php';

$li = new Listener();
$li->setRequest($_SERVER);
$li->process();