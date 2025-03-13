<?php
// app/core/Router.php

namespace app\core;

class Router {
    private $routes = [];

    public function add($route, $controllerAction) {
        $this->routes[$route] = $controllerAction;
    }

    public function dispatch($uri) {
        foreach ($this->routes as $route => $controllerAction) {
            if ($route === $uri) {
                list($controller, $action) = explode('@', $controllerAction);
                $controller = "app\\controllers\\$controller"; 
                $controller = new $controller();
                $controller->$action();
                return;
            }
        }

        // Handle 404
        http_response_code(404);
        echo '404 - Page not found';
    }
}