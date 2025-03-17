<?php

require_once __DIR__ . '/../app/bootstrap.php';

// Get the router instance
$router = new app\core\Router();

// Load routes
require_once __DIR__ . '/../app/routes.php';

// Direct traffic based on the request
$router->direct(app\core\Request::uri(), app\core\Request::method());