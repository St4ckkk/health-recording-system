<?php
// public/index.php

// Bootstrap the application
require __DIR__ . '/../app/bootstrap.php';

// Initialize the router
$router = new app\core\Router();

// Define routes
$router->add('/', 'HomeController@index');
$router->add('/appointment/doctor-availability', 'HomeController@appointment');
$router->add('/appointment/scheduling', 'HomeController@scheduling');
$router->add('/referral', 'HomeController@referral');

$router->add('/receptionist/dashboard', 'ReceptionistController@dashboard');
$router->add('/receptionist/appointments', 'ReceptionistController@appointments');

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI']);