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
        // First try exact match
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        // If no exact match, try to match patterns with parameters
        foreach ($this->routes[$requestType] as $route => $action) {
            // Check if route contains a parameter placeholder (e.g., :token)
            if (strpos($route, ':') !== false) {
                $pattern = preg_replace('#:[^/]+#', '([^/]+)', $route);
                $pattern = '#^' . $pattern . '$#';

                if (preg_match($pattern, $uri, $matches)) {
                    // Extract parameter values
                    array_shift($matches); // Remove the full match

                    // Call the action with parameters
                    return $this->callActionWithParams(
                        explode('@', $action),
                        $matches
                    );
                }
            }
        }

        // No route found
        throw new \Exception('No route defined for this URI: ' . $uri);
    }

    protected function callAction($controller, $action)
    {
        $controller = "app\\controllers\\{$controller}";
        $controller = new $controller();

        if (!method_exists($controller, $action)) {
            throw new \Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return $controller->$action();
    }

    protected function callActionWithParams($controllerAction, $params)
    {
        list($controller, $action) = $controllerAction;

        $controller = "app\\controllers\\{$controller}";
        $controller = new $controller();

        if (!method_exists($controller, $action)) {
            throw new \Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return $controller->$action($params);
    }
}
