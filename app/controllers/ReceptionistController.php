<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\Doctor;
use app\models\DoctorTimeSlot;
use app\models\Patient;
use app\helpers\EmailHelper; // Add this line

class ReceptionistController extends Controller
{
    private $appointmentModel;
    private $doctorModel;
    private $timeSlotModel;
    private $patientModel;
    private $emailHelper; // Add this line

    public function __construct()
    {
        $this->appointmentModel = new Appointment();
        $this->doctorModel = new Doctor();
        $this->timeSlotModel = new DoctorTimeSlot();
        $this->patientModel = new Patient();
        $this->emailHelper = new EmailHelper();
    }

    public function dashboard()
    {
        // Get appointment statistics
        $stats = $this->appointmentModel->getAppointmentStats();

        // Get upcoming, today's, and past appointments
        $upcomingAppointments = $this->appointmentModel->getUpcomingAppointments();
        $todayAppointments = $this->appointmentModel->getTodayAppointments();
        $pastAppointments = $this->appointmentModel->getPastAppointments();

        // Get all appointments for the appointment list
        $allAppointments = $this->appointmentModel->getAllAppointments();

        $this->view('pages/receptionist/dashboard', [
            'title' => 'Receptionist Dashboard',
            'stats' => $stats,
            'upcomingAppointments' => $upcomingAppointments,
            'todayAppointments' => $todayAppointments,
            'pastAppointments' => $pastAppointments,
            'allAppointments' => $allAppointments
        ]);
    }

    public function appointments()
    {

        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'upcoming';

        $allAppointments = $this->appointmentModel->getAllAppointments();
        $upcomingAppointments = $this->appointmentModel->getUpcomingAppointments();
        $pastAppointments = $this->appointmentModel->getPastAppointments();


        $displayAppointments = $allAppointments;
        if ($tab === 'upcoming') {
            $displayAppointments = $upcomingAppointments;
        } elseif ($tab === 'past') {
            $displayAppointments = $pastAppointments;
        }

        error_log("Displaying " . count($displayAppointments) . " appointments for tab: " . $tab);

        $this->view('pages/receptionist/appointments', [
            'title' => 'Appointments',
            'allAppointments' => $allAppointments,
            'upcomingAppointments' => $upcomingAppointments,
            'pastAppointments' => $pastAppointments,
            'displayAppointments' => $displayAppointments,
            'activeTab' => $tab
        ]);
    }

    public function notification()
    {
        $this->view('pages/receptionist/notification', [
            'title' => 'Notification'
        ]);
    }

    // Change from doctorSchedules() to doctor_schedules()
    public function doctor_schedules()
    {
        // Get all doctors with their availability information
        $doctors = $this->doctorModel->getAllDoctors('available');

        // Process each doctor to add available days and full name
        foreach ($doctors as $doctor) {
            // Get available days
            $doctor->available_days = $this->timeSlotModel->getDoctorAvailableDays($doctor->id);

            // Get full name
            $doctor->full_name = $this->doctorModel->getFullName($doctor);
        }

        $this->view('pages/receptionist/doctor_schedules', [
            'title' => 'Doctor Schedules',
            'doctors' => $doctors
        ]);
    }

    /**
     * Add a new doctor
     */
    public function add_doctor()
    {
        // Check if this is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            header('Location: ' . BASE_URL . '/receptionist/doctor_schedules');
            exit;
        }

        try {
            // Get form data
            $firstName = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
            $lastName = isset($_POST['lastname']) ? trim($_POST['lastname']) : '';
            $middleName = isset($_POST['middlename']) ? trim($_POST['middlename']) : '';
            $suffix = isset($_POST['suffix']) ? trim($_POST['suffix']) : '';
            $specialty = isset($_POST['specialty']) ? trim($_POST['specialty']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            $location = isset($_POST['location']) ? trim($_POST['location']) : '';
            $maxAppointments = isset($_POST['maxAppointments']) ? intval($_POST['maxAppointments']) : 15;
            $status = isset($_POST['status']) ? trim($_POST['status']) : 'active';
            $availableDays = isset($_POST['availableDays']) ? $_POST['availableDays'] : [];

            // Get work hours
            $workHoursStart = isset($_POST['workHoursStart']) ? trim($_POST['workHoursStart']) : null;
            $workHoursEnd = isset($_POST['workHoursEnd']) ? trim($_POST['workHoursEnd']) : null;

            // Create validator instance
            $validator = new \app\core\Validator($_POST);

            // Validate required fields
            $validator->required(['firstname', 'lastname', 'specialty', 'email', 'phone'])
                ->email('email')
                ->minItems('availableDays', 1, 'Please select at least one available day');

            // Check if validation fails
            if ($validator->fails()) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => $validator->getFirstError()
                ]);
                return;
            }

            // Handle profile image upload
            $profileImage = null;
            if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
                // Validate file
                $fileValidator = new \app\core\Validator(['profileImage' => $_FILES['profileImage']]);
                $fileValidator->fileSize('profileImage', 2 * 1024 * 1024, 'Profile image must not exceed 2MB')
                    ->fileType('profileImage', ['image/jpeg', 'image/png', 'image/jpg'], 'Only JPG and PNG files are allowed');

                if ($fileValidator->fails()) {
                    $this->jsonResponse([
                        'success' => false,
                        'message' => $fileValidator->getFirstError()
                    ]);
                    return;
                }

                $profileImage = $this->handleProfileImageUpload($_FILES['profileImage']);
                if (is_array($profileImage) && isset($profileImage['error'])) {
                    $this->jsonResponse([
                        'success' => false,
                        'message' => $profileImage['error']
                    ]);
                    return;
                }
            }

            // Create doctor data array
            $doctorData = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'middle_name' => $middleName,
                'suffix' => $suffix,
                'specialization' => $specialty,
                'contact_number' => $phone,
                'email' => $email,
                'max_appointments_per_day' => $maxAppointments,
                'status' => $status,
                'default_location' => $location,
                'profile' => $profileImage,
                'created_at' => date('Y-m-d H:i:s'),
                'work_hours_start' => $workHoursStart,
                'work_hours_end' => $workHoursEnd
            ];

            // Debug log
            error_log('Doctor data: ' . print_r($doctorData, true));

            // Insert doctor into database
            $doctorId = $this->doctorModel->insert($doctorData);

            if (!$doctorId) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Failed to add doctor. Database error.'
                ]);
                return;
            }

            // Process time slots
            $this->processTimeSlots($doctorId, $availableDays);

            $this->jsonResponse([
                'success' => true,
                'message' => 'Doctor added successfully',
                'doctorId' => $doctorId
            ]);
        } catch (\Exception $e) {
            // Log the error
            error_log('Error in add_doctor: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Handle profile image upload
     * 
     * @param array $file The uploaded file data
     * @return string|array The filename if successful, or an array with error message
     */
    private function handleProfileImageUpload($file)
    {
        // Define uploads directory using proper file system path
        $uploadsDir = dirname(APP_ROOT) . '/public/uploads/doctors';

        // Check if uploads directory exists, if not create it
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }

        // We no longer need these validations as they're handled by the Validator class
        // Just move the uploaded file
        $filename = uniqid() . '_' . time() . '_' . str_replace(' ', '_', $file['name']);
        $destination = $uploadsDir . '/' . $filename;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['error' => 'Failed to upload file'];
        }

        // Return the relative path for database storage
        return 'uploads/doctors/' . $filename;
    }

    /**
     * Process time slots for a doctor
     * 
     * @param int $doctorId The doctor ID
     * @param array $availableDays The available days
     */
    private function processTimeSlots($doctorId, $availableDays)
    {
        // Get time slots from POST data
        $startTimes = isset($_POST['startTimes']) ? $_POST['startTimes'] : [];
        $endTimes = isset($_POST['endTimes']) ? $_POST['endTimes'] : [];

        // Delete existing time slots for this doctor
        $this->timeSlotModel->deleteByField('doctor_id', $doctorId);

        // Process each available day
        foreach ($availableDays as $day) {
            // Process each time slot
            for ($i = 0; $i < count($startTimes); $i++) {
                if (isset($startTimes[$i]) && isset($endTimes[$i])) {
                    $slotData = [
                        'doctor_id' => $doctorId,
                        'day' => ucfirst(strtolower($day)), // Ensure proper capitalization (Monday, Tuesday, etc.)
                        'start_time' => $startTimes[$i],
                        'end_time' => $endTimes[$i],
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    // Insert time slot
                    $result = $this->timeSlotModel->insert($slotData);

                    // Debug log
                    if ($result) {
                        error_log('Inserted time slot: ' . print_r($slotData, true));
                    } else {
                        error_log('Failed to insert time slot: ' . print_r($slotData, true));
                    }
                }
            }
        }
    }

    /**
     * Get doctor schedule and upcoming appointments
     */
    public function get_doctor_schedule()
    {
        // Check if this is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            header('Location: ' . BASE_URL . '/receptionist/doctor_schedules');
            exit;
        }

        try {
            // Get doctor ID from query parameter
            $doctorId = isset($_GET['id']) ? intval($_GET['id']) : 0;

            if ($doctorId <= 0) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Invalid doctor ID'
                ]);
                return;
            }

            // Get doctor schedule
            $doctor = $this->doctorModel->getDoctorSchedule($doctorId);

            if (!$doctor) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Doctor not found'
                ]);
                return;
            }

            // Get upcoming appointments
            $appointments = $this->doctorModel->getDoctorUpcomingAppointments($doctorId);

            // Return the data as JSON
            $this->jsonResponse([
                'success' => true,
                'doctor' => $doctor,
                'appointments' => $appointments
            ]);
        } catch (\Exception $e) {
            // Log the error
            error_log('Error in get_doctor_schedule: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Confirm an appointment
     */
    public function confirmAppointment()
    {
        // Disable error output to prevent it from corrupting JSON
        ini_set('display_errors', 0);
        error_reporting(0);

        // Start output buffering to capture any unexpected output
        ob_start();

        // Check if this is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            header('Location: ' . BASE_URL . '/receptionist/appointments');
            exit;
        }

        try {
            // Get JSON data from request body
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            // Log the received data for debugging
            error_log('Received data in confirmAppointment: ' . print_r($data, true));

            if (!$data || !isset($data['appointmentId'])) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Invalid request data'
                ]);
                return;
            }

            $appointmentId = intval($data['appointmentId']);
            $sendConfirmation = isset($data['send_confirmation']) ? (bool) $data['send_confirmation'] : true;
            $notes = $data['special_instructions'] ?? '';

            error_log('Processing appointment ID: ' . $appointmentId);
            error_log('Send confirmation: ' . ($sendConfirmation ? 'true' : 'false'));
            error_log('Notes: ' . $notes);

            // Get the appointment
            $appointment = $this->appointmentModel->getAppointmentById($appointmentId);

            if (!$appointment) {
                error_log('Appointment not found with ID: ' . $appointmentId);
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Appointment not found'
                ]);
                return;
            }

            error_log('Found appointment: ' . print_r($appointment, true));

            // Update appointment status
            $updateData = [
                'status' => 'confirmed',
                'special_instructions' => $notes,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Log the update data for debugging
            error_log('Updating appointment with data: ' . print_r($updateData, true));

            // Try to update the appointment
            $success = $this->appointmentModel->update($appointmentId, $updateData);

            // Log the result
            error_log('Update result: ' . ($success ? 'success' : 'failure'));

            if ($success) {
                // Send confirmation email/SMS if requested
                if ($sendConfirmation && !empty($appointment->email)) {
                    try {
                        // Send confirmation email using EmailHelper
                        $emailSent = $this->emailHelper->sendAppointmentConfirmation($appointment, $notes);
                        error_log('Confirmation email ' . ($emailSent ? 'sent' : 'failed') . ' to: ' . $appointment->email);

                        // Even if email fails, we still consider the appointment confirmation successful
                    } catch (\Exception $e) {
                        error_log('Email error: ' . $e->getMessage());
                        // Continue with success response even if email fails
                    }
                }

                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Appointment confirmed successfully'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Failed to confirm appointment'
                ]);
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('Error in confirmAppointment: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());

            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }


    /**
     * Cancel an appointment
     */
    public function cancelAppointment()
    {
        // Disable error output to prevent it from corrupting JSON
        ini_set('display_errors', 0);
        error_reporting(0);

        // Start output buffering to capture any unexpected output
        ob_start();

        // Check if this is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            header('Location: ' . BASE_URL . '/receptionist/appointments');
            exit;
        }

        try {
            // Get JSON data from request body
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);

            // Log the received data for debugging
            error_log('Received data in cancelAppointment: ' . print_r($data, true));

            if (!$data || !isset($data['appointmentId']) || !isset($data['reason'])) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Invalid request data'
                ]);
                return;
            }

            $appointmentId = intval($data['appointmentId']);
            $reason = $data['reason'];
            $details = $data['details'] ?? '';

            // Get the appointment
            $appointment = $this->appointmentModel->getAppointmentById($appointmentId);

            if (!$appointment) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Appointment not found'
                ]);
                return;
            }

            // Update appointment status
            $updateData = [
                'status' => 'cancelled_by_clinic',
                'cancellation_reason' => $reason,
                'cancellation_details' => $details,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Log the update data for debugging
            error_log('Updating appointment with data: ' . print_r($updateData, true));

            $success = $this->appointmentModel->update($appointmentId, $updateData);

            if ($success) {
                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Appointment cancelled successfully'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Failed to cancel appointment'
                ]);
            }
        } catch (\Exception $e) {
            // Log the error
            error_log('Error in cancelAppointment: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * JSON response helper
     * 
     * @param array $data The data to send as JSON
     */
    private function jsonResponse($data)
    {
        // Clear any previous output that might corrupt the JSON
        if (ob_get_length()) {
            ob_clean();
        }

        // Discard any output that might have been generated
        ob_end_clean();

        // Start a new buffer
        ob_start();

        // Set proper headers
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');

        // Output JSON data
        echo json_encode($data);

        // Flush the buffer and end the script
        ob_end_flush();
        exit;
    }

    /**
     * Get appointment details via AJAX
     */
    public function getAppointmentDetails()
    {
        // Check if this is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            header('Location: ' . BASE_URL . '/receptionist/appointments');
            exit;
        }

        // Get appointment ID from POST data
        $appointmentId = isset($_POST['appointmentId']) ? intval($_POST['appointmentId']) : 0;
        $patientId = isset($_POST['patientId']) ? $_POST['patientId'] : '';

        if ($appointmentId <= 0) {
            $this->jsonResponse([
                'error' => 'Invalid appointment ID'
            ]);
            return;
        }

        try {
            // Get appointment details with patient information
            $appointment = $this->appointmentModel->getAppointmentById($appointmentId);

            if (!$appointment) {
                $this->jsonResponse([
                    'error' => 'Appointment not found'
                ]);
                return;
            }

            // Create a patient object from the appointment data
            // This ensures we always have patient data even if the Patient model fails
            $patient = [
                'patient_id' => $appointment->patient_id,
                'first_name' => $appointment->first_name,
                'last_name' => $appointment->last_name,
                'email' => $appointment->email,
                'contact_number' => $appointment->contact_number
            ];

            // Try to get additional patient details from the Patient model
            $patientFromDb = null;
            if (!empty($patientId)) {
                $patientFromDb = $this->patientModel->getPatientById($patientId);
            } else if (!empty($appointment->patient_id)) {
                $patientFromDb = $this->patientModel->getPatientById($appointment->patient_id);
            }

            // If we got patient details from the database, use those instead
            if ($patientFromDb) {
                $patient = $patientFromDb;
            }

            // Get doctor details if doctor_id exists
            $doctor = null;
            if (!empty($appointment->doctor_id)) {
                $doctor = $this->doctorModel->getDoctorById($appointment->doctor_id);
            }

            // Return the data as JSON
            $this->jsonResponse([
                'appointment' => $appointment,
                'patient' => $patient,
                'doctor' => $doctor
            ]);
        } catch (\Exception $e) {
            // Log the error
            error_log('Error in getAppointmentDetails: ' . $e->getMessage());

            // Return error as JSON
            $this->jsonResponse([
                'error' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Send appointment reminder to patient
     * 
     * @return void
     */
    public function sendReminder()
    {
        // Check if this is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            header('Location: ' . BASE_URL . '/receptionist/dashboard');
            exit;
        }

        try {
            // Get form data
            $appointmentId = isset($_POST['appointmentId']) ? intval($_POST['appointmentId']) : 0;
            $reminderType = isset($_POST['reminder_type']) ? trim($_POST['reminder_type']) : 'standard';
            $additionalMessage = isset($_POST['reminder_message']) ? trim($_POST['reminder_message']) : '';
            $sendEmail = isset($_POST['send_email']) && $_POST['send_email'] === 'on';

            // Validate appointment ID
            if ($appointmentId <= 0) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Invalid appointment ID'
                ]);
                return;
            }

            // Get appointment details
            $appointment = $this->appointmentModel->getAppointmentById($appointmentId);
            if (!$appointment) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Appointment not found'
                ]);
                return;
            }

            $currentInstructions = $appointment->special_instructions ?? '';
            $updatedInstructions = $currentInstructions;

            // Only add the message if it's not empty
            if (!empty($additionalMessage)) {
                if (!empty($updatedInstructions)) {
                    $updatedInstructions .= "\n\n" . $additionalMessage;
                } else {
                    $updatedInstructions = $additionalMessage;
                }
            }

            $updateData = [
                'special_instructions' => $updatedInstructions,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $updated = $this->appointmentModel->update($appointmentId, $updateData);

            if (!$updated) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Failed to update appointment with reminder information'
                ]);
                return;
            }

            // Send email if requested
            $emailSent = true;
            if ($sendEmail && !empty($appointment->email)) {
                // Prepare email data
                $emailData = [
                    'patient_name' => $appointment->first_name . ' ' . $appointment->last_name,
                    'doctor_name' => 'Dr. ' . $appointment->doctor_first_name . ' ' . $appointment->doctor_last_name,
                    'appointment_date' => date('l, F j, Y', strtotime($appointment->appointment_date)),
                    'appointment_time' => date('h:i A', strtotime($appointment->appointment_time)),
                    'appointment_type' => $appointment->type,
                    'tracking_number' => $appointment->tracking_number,
                    'additional_message' => $additionalMessage,
                    'clinic_name' => $_ENV['CLINIC_NAME'] ?? 'Health Recording System',
                    'clinic_address' => $_ENV['CLINIC_ADDRESS'] ?? '123 Medical Center Blvd, Health City',
                    'clinic_phone' => $_ENV['CLINIC_PHONE'] ?? '(123) 456-7890'
                ];

                // Choose template based on reminder type
                $template = $reminderType === 'detailed' ? 'appointment_reminder_detailed' : 'appointment_reminder_standard';

                // Send the email
                $emailSent = $this->emailHelper->sendAppointmentReminder(
                    $appointment->email,
                    $appointment->first_name . ' ' . $appointment->last_name,
                    $template,
                    $emailData
                );
            }

            // Return success response
            $this->jsonResponse([
                'success' => true,
                'message' => 'Reminder sent successfully',
                'emailSent' => $emailSent
            ]);
        } catch (\Exception $e) {
            // Log the error
            error_log('Error in sendReminder: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }
}




