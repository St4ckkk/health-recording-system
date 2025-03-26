<?php

$router->get('/', 'HomeController@index');
$router->get('/appointment/doctor-availability', 'HomeController@appointment');

// Change to use a single route without parameters
$router->get('/appointment/scheduling', 'HomeController@scheduling');

$router->get('/referral', 'HomeController@referral');

$router->get('/appointment/appointment-tracking', 'HomeController@appointment_tracking');
$router->post('/track-appointment', 'HomeController@track_appointment');

// Update these routes to use query parameters instead
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

// Change this line to use a query parameter instead of a URL parameter
$router->get('/receptionist/get_doctor_schedule', 'ReceptionistController@get_doctor_schedule');
$router->post('/receptionist/cancel-appointment', 'ReceptionistController@cancelAppointment');
// Add a debug route to test session handling
$router->get('/debug-session', function () {
    error_log("Debug session route called");
    echo "<pre>";
    echo "Session contents: ";
    print_r($_SESSION);
    echo "</pre>";
    exit;
});

