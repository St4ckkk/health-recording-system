<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\Doctor;
use app\models\DoctorTimeSlot;
use app\models\Patient;

class ReceptionistController extends Controller
{
    private $appointmentModel;
    private $doctorModel;
    private $timeSlotModel;
    private $patientModel;

    public function __construct()
    {
        $this->appointmentModel = new Appointment();
        $this->doctorModel = new Doctor();
        $this->timeSlotModel = new DoctorTimeSlot();
        $this->patientModel = new Patient();
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
        // Get tab parameter from URL, default to 'upcoming'
        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'upcoming';

        // Get all appointments with patient and doctor information
        $allAppointments = $this->appointmentModel->getAllAppointments();

        // Debug log to check if appointments are being retrieved
        error_log("Retrieved " . count($allAppointments) . " total appointments");

        // Get upcoming appointments
        $upcomingAppointments = $this->appointmentModel->getUpcomingAppointments();
        error_log("Retrieved " . count($upcomingAppointments) . " upcoming appointments");

        // Get past appointments
        $pastAppointments = $this->appointmentModel->getPastAppointments();
        error_log("Retrieved " . count($pastAppointments) . " past appointments");

        // Determine which appointments to display based on tab
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

            // Validate required fields
            if (empty($firstName) || empty($lastName) || empty($specialty) || empty($email) || empty($phone)) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Please fill in all required fields'
                ]);
                return;
            }

            // Handle profile image upload
            $profileImage = null;
            if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
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
        // Check if uploads directory exists, if not create it
        $uploadsDir = PUBLIC_DIR . 'uploads/doctors';
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file['type'], $allowedTypes)) {
            return ['error' => 'Only JPG and PNG files are allowed'];
        }

        // Validate file size (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            return ['error' => 'File size exceeds 2MB'];
        }

        // Generate unique filename
        $filename = uniqid() . '_' . time() . '_' . str_replace(' ', '_', $file['name']);
        $destination = $uploadsDir . '/' . $filename;

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['error' => 'Failed to upload file'];
        }

        return $filename;
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

        // Debug log
        error_log('Processing time slots for doctor ID: ' . $doctorId);
        error_log('Available days: ' . print_r($availableDays, true));
        error_log('Start times: ' . print_r($startTimes, true));
        error_log('End times: ' . print_r($endTimes, true));

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
     * JSON response helper
     * 
     * @param array $data The data to send as JSON
     */
    private function jsonResponse($data)
    {
        // Clear any previous output that might corrupt the JSON
        if (ob_get_length())
            ob_clean();

        // Set proper headers
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');

        // Output JSON data
        echo json_encode($data);
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
}
