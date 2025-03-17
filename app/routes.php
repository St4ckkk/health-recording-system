<?php

$router->get('/', 'HomeController@index');
$router->get('/appointment/doctor-availability', 'HomeController@appointment');
$router->get('/appointment/scheduling', 'HomeController@scheduling');
$router->get('/referral', 'HomeController@referral');


$router->get('/appointment/appointment-tracking', 'HomeController@appointment_tracking');
$router->post('/track-appointment', 'HomeController@track_appointment');

$router->get('/receptionist/dashboard', 'ReceptionistController@dashboard');
$router->get('/receptionist/appointments', 'ReceptionistController@appointments');
$router->get('/receptionist/notification', 'ReceptionistController@notification');
$router->get('/receptionist/doctor_schedules', 'ReceptionistController@doctor_schedules');