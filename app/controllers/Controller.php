<?php


namespace app\controllers;

class Controller
{
    // Load the view
    protected function view($view, $data = [])
    {
        // Extract data to make variables available in the view
        if (!empty($data)) {
            extract($data);
        }

        // Add BASE_URL to all views
        $base_url = defined('BASE_URL') ? BASE_URL : '';

        // Check if view file exists
        $viewFile = VIEW_ROOT . '/' . $view . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            // View not found
            die('View "' . $view . '" not found');
        }
    }

    /**
     * Redirect to a specific URL
     * 
     * @param string $url The URL to redirect to
     * @param bool $isPermanent Whether the redirect is permanent (301) or temporary (302)
     * @return void
     */
    protected function redirect($url, $isPermanent = false)
    {
        // If URL doesn't start with http or https, prepend BASE_URL
        if (!preg_match('/^https?:\/\//', $url)) {
            $url = BASE_URL . $url;
        }

        // Set the appropriate status code
        $statusCode = $isPermanent ? 301 : 302;

        // Send the header
        header('Location: ' . $url, true, $statusCode);
        exit;
    }
}