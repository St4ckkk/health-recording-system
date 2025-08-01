<?php

$router->get('/', 'HomeController@index');
$router->get('/rpm', 'HomeController@rpm');
$router->get('/appointment/doctor-availability', 'HomeController@appointment');
$router->get('/appointment/scheduling', 'HomeController@scheduling');
$router->get('/referral', 'HomeController@referral');
$router->get('/appointment/appointment-tracking', 'HomeController@appointment_tracking');
$router->post('/track-appointment', 'HomeController@track_appointment');
$router->get('/appointment/get-available-time-slots', 'HomeController@get_available_time_slots');
$router->post('/appointment/book', 'HomeController@book_appointment');
$router->get('/appointment/confirmation', 'HomeController@confirmation');
$router->get('/onBoarding', 'HomeController@onBoarding');



$router->get('/staff', 'SessionController@login');
$router->post('/staff', 'SessionController@login');
$router->get('/doctor', 'DoctorSessionController@login');
$router->post('/doctor', 'DoctorSessionController@login');
$router->get('/doctor/logout', 'DoctorSessionController@logout');
$router->get('/logout', 'SessionController@logout');


// Receptionist routes
$router->get('/receptionist/dashboard', 'ReceptionistController@dashboard');
$router->get('/receptionist/appointments', 'ReceptionistController@appointments');
$router->get('/receptionist/patients', 'ReceptionistController@patients');
$router->get('/receptionist/notification', 'ReceptionistController@notification');
$router->get('/receptionist/doctor_schedules', 'ReceptionistController@doctor_schedules');
$router->post('/receptionist/check-in-patient', 'ReceptionistController@checkInPatient');
$router->post('/receptionist/start-appointment', 'ReceptionistController@startAppointment');
$router->post('/receptionist/complete-appointment', 'ReceptionistController@completeAppointment');
$router->post('/receptionist/add_doctor', 'ReceptionistController@add_doctor');
$router->get('/receptionist/appointment/details', 'ReceptionistController@appointmentDetails');
$router->post('/receptionist/getAppointmentDetails', 'ReceptionistController@getAppointmentDetails');
$router->get('/receptionist/get_doctor_schedule', 'ReceptionistController@get_doctor_schedule');
$router->post('/receptionist/cancel-appointment', 'ReceptionistController@cancelAppointment');
$router->post('/receptionist/confirm-appointment', 'ReceptionistController@confirmAppointment');
$router->post('/receptionist/send-reminder', 'ReceptionistController@sendReminder');
$router->post('/receptionist/schedule-follow-up', 'ReceptionistController@scheduleFollowUp');
$router->get('/receptionist/appointments/records/{id}', 'ReceptionistController@viewPatientAppointmentRecords');
$router->get('/receptionist/appointments/records', 'ReceptionistController@viewPatientAppointmentRecords');
$router->get('/receptionist/appointment/details', 'ReceptionistController@appointmentDetails');

// Doctor routes
$router->get('/doctor/dashboard', 'DoctorController@dashboard');
$router->get('/doctor/patients', 'DoctorController@patientList');
$router->get('/doctor/patientView', 'DoctorController@patientView');
$router->get('/doctor/notification', 'DoctorController@notifications');
$router->get('/doctor/checkup', 'DoctorController@checkup');
$router->get('/doctor/reports', 'DoctorController@reports');
$router->get('/doctor/get-medicine-categories', 'DoctorController@getMedicineCategories');
$router->get('/doctor/search-medicines', 'DoctorController@searchMedicines');
$router->post('/doctor/save-checkup', 'DoctorController@saveCheckup');
$router->get('/doctor/appointments', 'DoctorController@appointments');
$router->get('/doctor/prescriptions', 'DoctorController@prescriptions');
$router->post('/doctor/preview-prescription', 'DoctorController@previewPrescription');
$router->post('/doctor/save-prescription', 'DoctorController@savePrescription');
$router->post('/doctor/email-prescription', 'DoctorController@emailPrescription');
$router->get('/doctor/treatment-records/view', 'DoctorController@treatmentDetails');
$router->get('/doctor/admission/view', 'DoctorController@admissionDetails');
$router->get('/doctor/immunization/view', 'DoctorController@immunizationDetails');
$router->get('/doctor/prescription/view', 'DoctorController@prescriptionDetails');
$router->post('/doctor/saveAdmission', 'DoctorController@saveAdmission');
$router->post('/doctor/updateAdmissionStatus', 'DoctorController@updateAdmissionStatus');
$router->post('/doctor/saveImmunization', 'DoctorController@saveImmunization');
$router->post('/doctor/saveTreatment', 'DoctorController@saveTreatment');
$router->post('/doctor/updateTreatment', 'DoctorController@updateTreatment');



// Pharmacist routes
$router->get('/pharmacist/dashboard', 'PharmacistController@dashboard');
$router->get('/pharmacist/medicinesInventory', 'PharmacistController@medicineInventory');
$router->get('/pharmacist/medicineLogs', 'PharmacistController@medicineLogs');
$router->get('/pharmacist/reports', 'PharmacistController@reports');
$router->post('/pharmacist/addMedicine', 'PharmacistController@addMedicine');
$router->post('/pharmacist/deleteMedicine', 'PharmacistController@deleteMedicine');
$router->post('/pharmacist/updateMedicine', 'PharmacistController@updateMedicine');
$router->post('/pharmacist/dispenseMedicine', 'PharmacistController@dispenseMedicine');



$router->post('/api/monitoring/send-request', 'PatientController@sendMonitoringRequest');
$router->get('/patient/monitoring/dashboard', 'PatientController@monitoringDashboard');
$router->get('/symptoms-checker', 'PatientController@symptomsChecker');
$router->post('/analyze-symptoms', 'PatientController@analyzeSymptoms');
$router->get('/patient/verify/:token', 'PatientController@showVerification');
$router->post('/patient/verify/:token', 'PatientController@verifyCode');



// Admin routes
$router->get('/admin/dashboard', 'AdminController@dashboard');
$router->get('/admin/staff', 'AdminController@staffManagement');
$router->post('/admin/addStaff', 'AdminController@addStaff');
$router->get('/admin/transactions', 'AdminController@transactionRecords');
$router->get('/admin/billing-records', 'AdminController@billingRecords');
$router->get('/admin/getBillingDetails', 'AdminController@getBillingDetails');
$router->post('/admin/updateBillingStatus', 'AdminController@updateBillingStatus');
$router->post('/admin/deleteStaff', 'AdminController@deleteStaff');
$router->get('/admin/doctors', 'AdminController@doctorManagement');
$router->get('/admin/medicine-inventory', 'AdminController@medicineInventory');
$router->get('/admin/medicine-logs', 'AdminController@medicineLogs');
$router->get('/admin/billing-records', 'AdminController@billingRecords');
$router->get('/admin/medical-records', 'AdminController@medicalRecords');
$router->get('/admin/patients', 'AdminController@patientManagement');
$router->get('/admin/appointments', 'AdminController@appointmentManagement');
$router->get('/admin/reports', 'AdminController@reports');
$router->get('/admin/settings', 'AdminController@systemSettings');
$router->post('/admin/settings', 'AdminController@saveSystemSettings');