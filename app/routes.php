<?php

$router->get('/', 'HomeController@index');
$router->get('/appointment/doctor-availability', 'HomeController@appointment');

$router->get('/appointment/scheduling', 'HomeController@scheduling');

$router->get('/referral', 'HomeController@referral');

$router->get('/appointment/appointment-tracking', 'HomeController@appointment_tracking');
$router->post('/track-appointment', 'HomeController@track_appointment');

$router->get('/appointment/get-available-time-slots', 'HomeController@get_available_time_slots');
$router->post('/appointment/book', 'HomeController@book_appointment');
$router->get('/appointment/confirmation', 'HomeController@confirmation');

$router->get('/receptionist/dashboard', 'ReceptionistController@dashboard');
$router->get('/receptionist/appointments', 'ReceptionistController@appointments');
$router->get('/receptionist/notification', 'ReceptionistController@notification');
$router->get('/receptionist/doctor_schedules', 'ReceptionistController@doctor_schedules');
$router->post('/receptionist/add_doctor', 'ReceptionistController@add_doctor');
$router->get('/receptionist/appointment/details', 'ReceptionistController@appointmentDetails');
$router->post('/receptionist/getAppointmentDetails', 'ReceptionistController@getAppointmentDetails');
$router->get('/receptionist/get_doctor_schedule', 'ReceptionistController@get_doctor_schedule');
$router->post('/receptionist/cancel-appointment', 'ReceptionistController@cancelAppointment');
