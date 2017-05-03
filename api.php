<?php

define('APP_PATH', __DIR__ . '/src/app');
require APP_PATH . DIRECTORY_SEPARATOR . 'Core/App.php';

$app = \App\Core\App::getInstance();
$app->register();

App\Core\start();