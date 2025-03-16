<?php

require __DIR__ . '/../app/bootstrap.php';


$router = new app\core\Router();


$router->add('/', 'HomeController@index');
$router->add('/appointment/doctor-availability', 'HomeController@appointment');
$router->add('/appointment/scheduling', 'HomeController@scheduling');
$router->add('/referral', 'HomeController@referral');

$router->add('/receptionist/dashboard', 'ReceptionistController@dashboard');
$router->add('/receptionist/appointments', 'ReceptionistController@appointments');
$router->add('/receptionist/notification', 'ReceptionistController@notification');
$router->add('/receptionist/doctor_schedules', 'ReceptionistController@doctor_schedules');


$router->dispatch($_SERVER['REQUEST_URI']);