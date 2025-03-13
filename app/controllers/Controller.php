<?php


namespace app\controllers;

class Controller {
    // Load the view
    protected function view($view, $data = []) {
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
}