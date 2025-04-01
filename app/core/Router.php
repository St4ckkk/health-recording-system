<?php


namespace app\core;

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public function add($route, $controllerAction)
    {
        $this->routes[$route] = $controllerAction;
    }

    public function dispatch($uri)
    {
        foreach ($this->routes as $route => $controllerAction) {
            if ($route === $uri) {
                if (is_string($controllerAction)) {
                    list($controller, $action) = explode('@', $controllerAction);
                } else {
                    throw new \Exception('Controller action must be a string');
                }
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

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        // Change from app\core\Exception to \Exception
        throw new \Exception('No route defined for this URI: ' . $uri);
    }

    protected function callAction($controller, $action)
    {
        $controllerClass = "app\\controllers\\{$controller}";

        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller {$controller} does not exist.");
        }

        $controllerInstance = new $controllerClass();

        if (!method_exists($controllerInstance, $action)) {
            throw new \Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return $controllerInstance->$action();
    }
}


// Add this route to your routes array or registration method
