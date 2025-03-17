<?php

namespace app\core;

class Request
{
    /**
     * Get the URI from the request
     * 
     * @return string
     */
    public static function uri()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        
        // Handle subdirectory if needed
        $position = strpos($uri, 'health-recording-system/');
        if ($position !== false) {
            $uri = substr($uri, $position + strlen('health-recording-system/'));
        }
        
        return $uri === '' ? '/' : '/' . $uri;
    }

    /**
     * Get the request method
     * 
     * @return string
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    /**
     * Get a specific value from the request
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        if (self::method() === 'GET') {
            return isset($_GET[$key]) ? $_GET[$key] : $default;
        }
        
        if (self::method() === 'POST') {
            return isset($_POST[$key]) ? $_POST[$key] : $default;
        }
        
        return $default;
    }
    
    /**
     * Get all request data
     * 
     * @return array
     */
    public static function all()
    {
        if (self::method() === 'GET') {
            return $_GET;
        }
        
        if (self::method() === 'POST') {
            return $_POST;
        }
        
        return [];
    }
}