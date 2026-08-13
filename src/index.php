<?php

define('BASE_PATH', __DIR__);

require BASE_PATH . '/app/autoload.php';

use App\Core\Router;

session_start();

Router::dispatch();
