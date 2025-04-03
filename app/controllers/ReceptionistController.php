<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\Doctor;
use app\models\DoctorTimeSlot;
use app\models\Patient;
use app\helpers\email\AppointmentConfirmation;
use app\helpers\email\ReminderEmail;
use app\helpers\email\FollowUpEmail;
use app\helpers\TrackingNumber;

class ReceptionistController extends Controller
{
    private $appointmentModel;
    private $doctorModel;
    private $timeSlotModel;
    private $patientModel;
    private $reminderEmailHelper;
    private $followUpEmailHelper;
    private $appointmentConfirmationHelper;
    private $trackingNumberHelper;

    public function __construct()
    {
        $this->appointmentModel = new Appointment();
        $this->doctorModel = new Doctor();
        $this->timeSlotModel = new DoctorTimeSlot();
        $this->patientModel = new Patient();
        $this->appointmentConfirmationHelper = new AppointmentConfirmation();
        $this->reminderEmailHelper = new ReminderEmail();
        $this->followUpEmailHelper = new FollowUpEmail();
        $this->trackingNumberHelper = new TrackingNumber();
    }

    /**
     * Display the receptionist dashboard with appointment statistics
     */
    public function dashboard()
    {


        // Get appointment statistics and categorized appointments
        $stats = $this->appointmentModel->getAppointmentStats();
        $upcomingAppointments = $this->appointmentModel->getUpcomingAppointments();
        $todayAppointments = $this->appointmentModel->getTodayAppointments();
        $pastAppointments = $this->appointmentModel->getPastAppointments();
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

    /**
     * Display appointments with filtering by tab
     */
    public function appointments()
    {
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'upcoming';

        $allAppointments = $this->appointmentModel->getAllAppointments();
        $upcomingAppointments = $this->appointmentModel->getUpcomingAppointments();
        $pastAppointments = $this->appointmentModel->getPastAppointments();

        $displayAppointments = match ($tab) {
            'upcoming' => $upcomingAppointments,
            'past' => $pastAppointments,
            default => $allAppointments
        };

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

    /**
     * Display notification page
     */
    public function notification()
    {
        $this->view('pages/receptionist/notification', [
            'title' => 'Notification'
        ]);
    }

    /**
     * Display doctor schedules
     */
    public function doctor_schedules()
    {
        // Get all available doctors
        $doctors = $this->doctorModel->getAllDoctors('available');

        // Process each doctor to add available days and full name
        foreach ($doctors as $doctor) {
            $doctor->available_days = $this->timeSlotModel->getDoctorAvailableDays($doctor->id);
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
        // Verify AJAX request
        if (!$this->isAjaxRequest()) {
            $this->redirect('/receptionist/doctor_schedules');
        }

        try {
            // Extract and validate form data
            $doctorData = $this->extractDoctorFormData();
            $validator = $this->validateDoctorData($doctorData);

            if ($validator->fails()) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => $validator->getFirstError()
                ]);
                return;
            }

            // Handle profile image upload
            $profileImage = $this->handleDoctorProfileImage();
            if (is_array($profileImage) && isset($profileImage['error'])) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => $profileImage['error']
                ]);
                return;
            }

            // Prepare doctor data for database
            $doctorData = $this->prepareDoctorData($doctorData, $profileImage);

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
            $this->processTimeSlots($doctorId, $doctorData['availableDays']);

            $this->jsonResponse([
                'success' => true,
                'message' => 'Doctor added successfully',
                'doctorId' => $doctorId
            ]);
        } catch (\Exception $e) {
            $this->logError('Error in add_doctor', $e);
            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Extract doctor form data from POST request
     */
    private function extractDoctorFormData()
    {
        return [
            'firstName' => $_POST['firstname'] ?? '',
            'lastName' => $_POST['lastname'] ?? '',
            'middleName' => $_POST['middlename'] ?? '',
            'suffix' => $_POST['suffix'] ?? '',
            'specialty' => $_POST['specialty'] ?? '',
            'email' => $_POST['email'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'location' => $_POST['location'] ?? '',
            'maxAppointments' => intval($_POST['maxAppointments'] ?? 15),
            'status' => $_POST['status'] ?? 'active',
            'availableDays' => $_POST['availableDays'] ?? [],
            'workHoursStart' => $_POST['workHoursStart'] ?? null,
            'workHoursEnd' => $_POST['workHoursEnd'] ?? null
        ];
    }

    /**
     * Validate doctor data
     */
    private function validateDoctorData($data)
    {
        $validator = new \app\core\Validator($_POST);

        // Validate required fields
        $validator->required(['firstname', 'lastname', 'specialty', 'email', 'phone'])
            ->email('email')
            ->minItems('availableDays', 1, 'Please select at least one available day');

        return $validator;
    }

    /**
     * Prepare doctor data for database insertion
     */
    private function prepareDoctorData($data, $profileImage)
    {
        return [
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'middle_name' => $data['middleName'],
            'suffix' => $data['suffix'],
            'specialization' => $data['specialty'],
            'contact_number' => $data['phone'],
            'email' => $data['email'],
            'max_appointments_per_day' => $data['maxAppointments'],
            'status' => $data['status'],
            'default_location' => $data['location'],
            'profile' => $profileImage,
            'created_at' => date('Y-m-d H:i:s'),
            'work_hours_start' => $data['workHoursStart'],
            'work_hours_end' => $data['workHoursEnd']
        ];
    }

    /**
     * Handle profile image upload
     */
    private function handleDoctorProfileImage()
    {
        if (!isset($_FILES['profileImage']) || $_FILES['profileImage']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Validate file
        $fileValidator = new \app\core\Validator(['profileImage' => $_FILES['profileImage']]);
        $fileValidator->fileSize('profileImage', 2 * 1024 * 1024, 'Profile image must not exceed 2MB')
            ->fileType('profileImage', ['image/jpeg', 'image/png', 'image/jpg'], 'Only JPG and PNG files are allowed');

        if ($fileValidator->fails()) {
            return ['error' => $fileValidator->getFirstError()];
        }

        // Define uploads directory
        $uploadsDir = dirname(APP_ROOT) . '/public/uploads/doctors';

        // Create directory if it doesn't exist
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }

        // Generate unique filename
        $filename = uniqid() . '_' . time() . '_' . str_replace(' ', '_', $_FILES['profileImage']['name']);
        $destination = $uploadsDir . '/' . $filename;

        // Move uploaded file
        if (!move_uploaded_file($_FILES['profileImage']['tmp_name'], $destination)) {
            return ['error' => 'Failed to upload file'];
        }

        // Return the relative path for database storage
        return 'uploads/doctors/' . $filename;
    }

    /**
     * Process time slots for a doctor
     */
    private function processTimeSlots($doctorId, $availableDays)
    {
        // Get time slots from POST data
        $startTimes = $_POST['startTimes'] ?? [];
        $endTimes = $_POST['endTimes'] ?? [];

        // Delete existing time slots for this doctor
        $this->timeSlotModel->deleteByField('doctor_id', $doctorId);

        // Process each available day
        foreach ($availableDays as $day) {
            // Process each time slot
            for ($i = 0; $i < count($startTimes); $i++) {
                if (isset($startTimes[$i]) && isset($endTimes[$i])) {
                    $slotData = [
                        'doctor_id' => $doctorId,
                        'day' => ucfirst(strtolower($day)),
                        'start_time' => $startTimes[$i],
                        'end_time' => $endTimes[$i],
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    // Insert time slot
                    $result = $this->timeSlotModel->insert($slotData);
                    $this->logTimeSlotResult($result, $slotData);
                }
            }
        }
    }

    /**
     * Log time slot insertion result
     */
    private function logTimeSlotResult($result, $slotData)
    {
        if ($result) {
            error_log('Inserted time slot: ' . print_r($slotData, true));
        } else {
            error_log('Failed to insert time slot: ' . print_r($slotData, true));
        }
    }

    /**
     * Get doctor schedule and upcoming appointments
     */
    public function get_doctor_schedule()
    {
        // Verify AJAX request
        if (!$this->isAjaxRequest()) {
            $this->redirect('/receptionist/doctor_schedules');
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
            $this->logError('Error in get_doctor_schedule', $e);
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
        $this->prepareJsonResponse();

        // Verify AJAX request
        if (!$this->isAjaxRequest()) {
            $this->redirect('/receptionist/appointments');
        }

        try {
            // Get JSON data from request body
            $data = $this->getJsonRequestData();

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
                'status' => 'confirmed',
                'special_instructions' => $notes,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $success = $this->appointmentModel->update($appointmentId, $updateData);

            if ($success) {
                // Send confirmation email if requested
                if ($sendConfirmation && !empty($appointment->email)) {
                    try {
                        $emailSent = $this->appointmentConfirmationHelper->sendAppointmentConfirmation($appointment, $notes);
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
            $this->logError('Error in confirmAppointment', $e);
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
        $this->prepareJsonResponse();

        // Verify AJAX request
        if (!$this->isAjaxRequest()) {
            $this->redirect('/receptionist/appointments');
        }

        try {
            // Get JSON data from request body
            $data = $this->getJsonRequestData();

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

            $success = $this->appointmentModel->update($appointmentId, $updateData);

            $this->jsonResponse([
                'success' => $success,
                'message' => $success ? 'Appointment cancelled successfully' : 'Failed to cancel appointment'
            ]);
        } catch (\Exception $e) {
            $this->logError('Error in cancelAppointment', $e);
            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get appointment details via AJAX
     */
    public function getAppointmentDetails()
    {
        // Verify AJAX request
        if (!$this->isAjaxRequest()) {
            $this->redirect('/receptionist/appointments');
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
            $patient = $this->extractPatientFromAppointment($appointment);

            // Try to get additional patient details from the Patient model
            $patientFromDb = $this->getPatientDetails($patientId, $appointment);

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
            $this->logError('Error in getAppointmentDetails', $e);
            $this->jsonResponse([
                'error' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Extract patient data from appointment
     */
    private function extractPatientFromAppointment($appointment)
    {
        return [
            'patient_id' => $appointment->patient_id,
            'first_name' => $appointment->first_name,
            'middle_name' => $appointment->middle_name,
            'last_name' => $appointment->last_name,
            'suffix' => $appointment->suffix,
            'email' => $appointment->email,
            'contact_number' => $appointment->contact_number,
            'patient_reference_number' => $appointment->patient_reference_number,
        ];
    }

    /**
     * Get patient details from database
     */
    private function getPatientDetails($patientId, $appointment)
    {
        if (!empty($patientId)) {
            return $this->patientModel->getPatientById($patientId);
        } else if (!empty($appointment->patient_id)) {
            return $this->patientModel->getPatientById($appointment->patient_id);
        }
        return null;
    }

    /**
     * Send appointment reminder to patient
     */
    public function sendReminder()
    {
        // Verify AJAX request
        if (!$this->isAjaxRequest()) {
            $this->redirect('/receptionist/dashboard');
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

            // Update appointment with reminder information
            $success = $this->updateAppointmentWithReminder($appointment, $additionalMessage);

            if (!$success) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Failed to update appointment with reminder information'
                ]);
                return;
            }

            // Send email if requested
            $emailSent = true;
            if ($sendEmail && !empty($appointment->email)) {
                $emailSent = $this->sendReminderEmail($appointment, $reminderType, $additionalMessage);
            }

            // Return success response
            $this->jsonResponse([
                'success' => true,
                'message' => 'Reminder sent successfully',
                'emailSent' => $emailSent
            ]);
        } catch (\Exception $e) {
            $this->logError('Error in sendReminder', $e);
            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update appointment with reminder information
     */
    private function updateAppointmentWithReminder($appointment, $additionalMessage)
    {
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

        return $this->appointmentModel->update($appointment->id, $updateData);
    }

    /**
     * Send reminder email
     */
    private function sendReminderEmail($appointment, $reminderType, $additionalMessage)
    {
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
        return $this->reminderEmailHelper->sendAppointmentReminder(
            $appointment->email,
            $appointment->first_name . ' ' . $appointment->last_name,
            $template,
            $emailData
        );
    }

    /**
     * Check in a patient for their appointment
     */
    public function checkInPatient()
    {
        // Prepare for JSON response
        $this->prepareJsonResponse();

        // Check if the request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
            return;
        }

        try {
            // Get the appointment ID
            $appointmentId = isset($_POST['appointmentId']) ? $_POST['appointmentId'] : null;

            // Validate appointment ID
            if (!$appointmentId) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Appointment ID is required'
                ]);
                return;
            }

            // Get the appointment
            $appointment = $this->appointmentModel->getById($appointmentId);
            if (!$appointment) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Appointment not found'
                ]);
                return;
            }

            // Get check-in details
            $checkInData = [
                'insurance_verified' => isset($_POST['verify_insurance']) ? $_POST['verify_insurance'] : '0',
                'id_verified' => isset($_POST['verify_id']) ? $_POST['verify_id'] : '0',
                'forms_completed' => isset($_POST['forms_completed']) ? $_POST['forms_completed'] : '0',
                'checked_in_at' => date('Y-m-d H:i:s')
            ];

            // Update appointment status to checked_in
            $result = $this->appointmentModel->checkInPatient($appointmentId, $checkInData);

            if ($result) {
                // Log the check-in
                $this->logActivity('Patient checked in', 'Appointment #' . $appointmentId . ' checked in');

                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Patient checked in successfully'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Failed to check in patient'
                ]);
            }
        } catch (\Exception $e) {
            $this->logError('Error in checkInPatient', $e);
            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Start an appointment
     */
    public function startAppointment()
    {
        // Prepare for JSON response
        $this->prepareJsonResponse();

        // Check if the request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
            return;
        }

        try {
            // Get the appointment ID
            $appointmentId = isset($_POST['appointmentId']) ? $_POST['appointmentId'] : null;

            // Validate appointment ID
            if (!$appointmentId) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Appointment ID is required'
                ]);
                return;
            }

            // Get the appointment
            $appointment = $this->appointmentModel->getById($appointmentId);
            if (!$appointment) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Appointment not found'
                ]);
                return;
            }

            // Update appointment status to in_progress
            $result = $this->appointmentModel->startAppointment($appointmentId, [
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            if ($result) {
                // Log the start
                $this->logActivity('Appointment started', 'Appointment #' . $appointmentId . ' started');

                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Appointment started successfully'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Failed to start appointment'
                ]);
            }
        } catch (\Exception $e) {
            $this->logError('Error in startAppointment', $e);
            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Complete an appointment
     */
    public function completeAppointment()
    {
        // Prepare for JSON response
        $this->prepareJsonResponse();

        // Check if the request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
            return;
        }

        try {
            // Get the appointment ID
            $appointmentId = isset($_POST['appointmentId']) ? $_POST['appointmentId'] : null;

            // Validate appointment ID
            if (!$appointmentId) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Appointment ID is required'
                ]);
                return;
            }

            // Get the appointment
            $appointment = $this->appointmentModel->getById($appointmentId);
            if (!$appointment) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Appointment not found'
                ]);
                return;
            }

            // Update appointment status to completed
            $result = $this->appointmentModel->completeAppointment($appointmentId, [
                'completed_at' => date('Y-m-d H:i:s')
            ]);

            if ($result) {
                // Log the completion
                $this->logActivity('Appointment completed', 'Appointment #' . $appointmentId . ' completed');

                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Appointment completed successfully'
                ]);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Failed to complete appointment'
                ]);
            }
        } catch (\Exception $e) {
            $this->logError('Error in completeAppointment', $e);
            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Schedule a follow-up appointment
     */
    public function scheduleFollowUp()
    {
        // Prepare for JSON response
        $this->prepareJsonResponse();

        // Check if the request is POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
            return;
        }

        try {
            // Get the appointment ID
            $appointmentId = isset($_POST['appointmentId']) ? $_POST['appointmentId'] : null;

            // Get follow-up details
            $followUpDate = isset($_POST['followUpDate']) ? $_POST['followUpDate'] : null;
            $followUpTime = isset($_POST['followUpTime']) ? $_POST['followUpTime'] : null;
            $followUpType = isset($_POST['followUpType']) ? $_POST['followUpType'] : 'follow_up';
            $followUpReason = isset($_POST['followUpReason']) ? $_POST['followUpReason'] : 'Follow-up appointment';

            // Log received data for debugging
            error_log("Follow-up data received: appointmentId=$appointmentId, date=$followUpDate, time=$followUpTime, type=$followUpType");

            // Validate required fields
            if (!$appointmentId || !$followUpDate) {
                error_log("Missing required fields for follow-up");
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Missing required fields'
                ]);
                return;
            }

            // Get the original appointment
            $originalAppointment = $this->appointmentModel->getAppointmentById($appointmentId);
            if (!$originalAppointment) {
                error_log("Original appointment not found: $appointmentId");
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Original appointment not found'
                ]);
                return;
            }

            $patient = $this->patientModel->getPatientById($originalAppointment->patient_id);
            if (!$patient) {
                error_log("Patient not found for appointment: $appointmentId");
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Patient record not found'
                ]);
                return;
            }




            // Create follow-up appointment data
            $followUpData = [
                'patient_id' => $patient->id,
                'doctor_id' => $originalAppointment->doctor_id,
                'appointment_date' => $followUpDate,
                'appointment_time' => $followUpTime,
                'status' => 'confirmed',
                'tracking_number' => $originalAppointment->tracking_number,
                'appointment_type' => $followUpType,
                'reason' => $followUpReason,
                'created_at' => date('Y-m-d H:i:s'),
                'is_follow_up' => 1,
                'original_appointment_id' => $originalAppointment->id
            ];

            // Log the data we're trying to insert
            error_log("Attempting to insert follow-up appointment: " . print_r($followUpData, true));

            // Insert the follow-up appointment
            $followUpId = $this->appointmentModel->insert($followUpData);

            if ($followUpId) {
                // Log the follow-up scheduling
                $this->logActivity('Follow-up scheduled', 'Follow-up appointment #' . $followUpId . ' scheduled for appointment #' . $appointmentId);
                error_log("Follow-up appointment created successfully with ID: $followUpId");

                // Send email notification if patient has email
                if (!empty($originalAppointment->email)) {
                    // Prepare email data
                    $emailData = [
                        'patient_name' => $originalAppointment->first_name . ' ' . $originalAppointment->last_name,
                        'doctor_name' => 'Dr. ' . $originalAppointment->doctor_first_name . ' ' . $originalAppointment->doctor_last_name,
                        'appointment_date' => date('l, F j, Y', strtotime($followUpDate)),
                        'appointment_time' => date('h:i A', strtotime($followUpTime)),
                        'tracking_number' => $originalAppointment->tracking_number,
                        'follow_up_reason' => $followUpReason,
                        'special_instructions' => '',
                        'clinic_name' => $_ENV['CLINIC_NAME'] ?? 'Health Recording System',
                        'clinic_address' => $_ENV['CLINIC_ADDRESS'] ?? '123 Medical Center Blvd, Health City',
                        'clinic_phone' => $_ENV['CLINIC_PHONE'] ?? '(123) 456-7890'
                    ];

                    try {
                        // Send the follow-up notification email
                        $this->followUpEmailHelper->sendFollowUpNotification(
                            $originalAppointment->email,
                            $originalAppointment->first_name . ' ' . $originalAppointment->last_name,
                            $emailData
                        );
                    } catch (\Exception $e) {
                        // Just log the email error but continue with success response
                        error_log("Email sending failed: " . $e->getMessage());
                    }
                }

                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Follow-up appointment scheduled successfully',
                    'followUpId' => $followUpId
                ]);
            } else {
                error_log("Failed to insert follow-up appointment into database");
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Failed to schedule follow-up appointment'
                ]);
            }
        } catch (\Exception $e) {
            $this->logError('Error in scheduleFollowUp', $e);
            $this->jsonResponse([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * View all appointment records for a specific patient
     * 
     * @return void
     */
    public function viewPatientAppointmentRecords()
    {

        $patientId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($patientId <= 0) {
            $this->redirect('receptionist/dashboard');
            return;
        }

        // Get patient information
        $patient = $this->patientModel->getPatientById($patientId);

        if (!$patient) {
            $this->redirect('receptionist/dashboard');
        }

        // Get all appointments for this patient
        $appointments = $this->appointmentModel->getAppointmentsByPatientId($patientId);

        // Load the view with the patient's appointment records
        $this->view('pages/receptionist/appointment-record.view', [
            'title' => 'Patient Appointment Records',
            'patient' => $patient,
            'appointments' => $appointments
        ]);
    }


    private function isAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }



    /**
     * Prepare for JSON response
     */
    private function prepareJsonResponse()
    {
        // Disable error output to prevent it from corrupting JSON
        ini_set('display_errors', 0);
        error_reporting(0);

        // Start output buffering to capture any unexpected output

        ob_start();
    }

    /**
     * Get JSON request data
     */
    private function getJsonRequestData()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        error_log('Received data: ' . print_r($data, true));
        return $data;
    }

    /**
     * JSON response helper
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
     * Log error with stack trace
     */
    private function logError($message, $exception)
    {
        error_log($message . ': ' . $exception->getMessage());
        error_log('Stack trace: ' . $exception->getTraceAsString());
    }

    /**
     * Helper method for logging activities
     */
    private function logActivity($action, $description)
    {
        // You can implement activity logging here if needed
        // For now, just log to error_log
        error_log("Activity: {$action} - {$description}");
    }
}