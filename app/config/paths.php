<?php
// Base URL detection
$base_url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://');
$base_url .= $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', rtrim($base_url, '/'));

// Path constants
define('APP_ROOT', dirname(__DIR__));
define('VIEW_ROOT', APP_ROOT . '/views');
define('PARTIALS_ROOT', VIEW_ROOT . '/components');
define('NODE_MODULES', __DIR__ . '/node_modules');
define('PUBLIC_DIR', __DIR__ . '/public');
define('CSS_DIR', PUBLIC_DIR . '/css');
define('JS_DIR', PUBLIC_DIR . '/js');
define('IMG_DIR', PUBLIC_DIR . '/img');
define('VIDEOS_DIR', PUBLIC_DIR . '/videos');

