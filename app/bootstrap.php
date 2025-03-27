<?php


require_once __DIR__ . '/config/paths.php';


spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});


require __DIR__ . '/core/Router.php';