<?php
session_start();

require_once __DIR__ . '/../app/bootstrap.php';


$router = new app\core\Router();


require_once __DIR__ . '/../app/routes.php';


$router->direct(app\core\Request::uri(), app\core\Request::method());