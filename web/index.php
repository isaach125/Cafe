<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/WebApplication.php';
require_once __DIR__ . '/../src/MainController.php';
//require_once __DIR__ . '/../setup/setup_database.php';

use Itb\WebApplication;

session_start();

$app = new WebApplication();
$app->run();