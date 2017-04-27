<?php

define('APP_PATH', __DIR__ . '/src/app');
require APP_PATH . DIRECTORY_SEPARATOR . 'Core/App.php';

$app = new App\Core\App();
$app->register();

$app->start();
