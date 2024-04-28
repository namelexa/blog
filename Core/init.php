<?php

use App\Check\Core\Router;

require_once 'vendor/autoload.php';
require_once 'functions.php';

$router = new Router();
$router->executeController();
