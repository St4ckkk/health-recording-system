<?php

require_once __DIR__ . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

session_start();

require_once __DIR__ . '/../app/bootstrap.php';


$router = new app\core\Router();


require_once __DIR__ . '/../app/routes.php';


$router->direct(app\core\Request::uri(), app\core\Request::method());