<?php

namespace app\controllers;

use app\models\Doctor;
use app\models\DoctorTimeSlot;
use app\models\Appointment;
use app\models\Patient;

class HomeController extends Controller
{
    private $doctorModel;
    private $timeSlotModel;
    private $appointmentModel;
    private $patientModel;

    public function __construct()
    {
        // Initialize models in the constructor
        $this->doctorModel = new Doctor();
        $this->timeSlotModel = new DoctorTimeSlot();
        $this->appointmentModel = new Appointment();
        $this->patientModel = new Patient();
    }

    public function index()
    {
        $this->view('index.view', [
            'title' => 'Health Recording System'
        ]);
    }

    public function appointment()
    {
        $doctors = $this->doctorModel->getAllDoctors();

        $specializations = [];
        if (!empty($doctors)) {
            $specializations = array_unique(array_column($doctors, 'specialization'));
        }

        $data = [
            'title' => 'Doctor Availability',
            'doctors' => $doctors,
            'specializations' => $specializations,
            'doctorModel' => $this->doctorModel,
            'timeSlotModel' => $this->timeSlotModel
        ];

        $this->view('pages/appointment/doctor-availability.view', $data);
    }

    // Updated to use query parameters
    public function scheduling()
    {
        // Get doctor ID from query parameter
        $doctorId = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : null;
        
        // If no doctor ID is provided, redirect to doctor availability page
        if (!$doctorId) {
            header('Location: ' . BASE_URL . '/appointment/doctor-availability');
            exit;
        }

        // Get doctor details
        $doctor = $this->doctorModel->getDoctorById($doctorId);
        
        if (!$doctor) {
            // Doctor not found, redirect to doctor availability page
            header('Location: ' . BASE_URL . '/appointment/doctor-availability');
            exit;
        }

        // Get doctor's available days and time slots
        $doctor->available_days = $this->timeSlotModel->getDoctorAvailableDays($doctorId);
        $doctor->time_slots = $this->timeSlotModel->getTimeSlotsByDoctorId($doctorId);
        
        // Format doctor's full name
        $doctor->full_name = $this->doctorModel->getFullName($doctor);

        $this->view('pages/appointment/scheduling.view', [
            'title' => 'Schedule Your Appointment',
            'doctor' => $doctor,
            'doctorModel' => $this->doctorModel,
            'timeSlotModel' => $this->timeSlotModel
        ]);
    }

    public function referral()
    {
        $this->view('pages/referral/referral', [
            'title' => 'Referral'
        ]);
    }

    public function appointment_tracking()
    {
        $this->view('pages/appointment/appointment-tracking.view', [
            'title' => 'Appointment Tracking'
        ]);
    }

    public function track_appointment() {
        try {
            // Check if this is an AJAX request
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
                header('Location: ' . BASE_URL . '/appointment-tracking');
                exit;
            }
            
            // Get tracking number from POST data or raw input
            $trackingNumber = isset($_POST['tracking_number']) ? trim($_POST['tracking_number']) : '';
            
            // If tracking number is empty, try to get it from the raw input
            if (empty($trackingNumber)) {
                $rawInput = file_get_contents('php://input');
                parse_str($rawInput, $parsedInput);
                $trackingNumber = isset($parsedInput['tracking_number']) ? trim($parsedInput['tracking_number']) : '';
            }
            
            // Validate tracking number
            if (empty($trackingNumber)) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Tracking number is required'
                ]);
                return;
            }
            
            // Get appointment details from the model
            $appointment = $this->appointmentModel->getAppointmentByTrackingNumber($trackingNumber);
            
            if (!$appointment) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'No appointment found with this tracking number'
                ]);
                return;
            }
            
            // Convert object to array if needed
            if (is_object($appointment)) {
                $appointment = (array) $appointment;
            }
            
            // Get doctor details
            $doctor = $this->doctorModel->getDoctorById($appointment['doctor_id']);
            
            // Set default doctor info if not found
            if (!$doctor) {
                $doctor = [
                    'id' => null,
                    'first_name' => 'Unknown',
                    'last_name' => 'Doctor',
                    'specialization' => 'Not specified'
                ];
                $doctorName = 'Unknown Doctor';
            } else {
                // Convert doctor object to array if needed
                if (is_object($doctor)) {
                    $doctor = (array) $doctor;
                }
                
                // Generate full doctor name
                $doctorName = $doctor['first_name'];
                if (!empty($doctor['middle_name'])) {
                    $doctorName .= ' ' . $doctor['middle_name'];
                }
                $doctorName .= ' ' . $doctor['last_name'];
                if (!empty($doctor['suffix'])) {
                    $doctorName .= ', ' . $doctor['suffix'];
                }
            }
            
            // Format the appointment data for the response
            $formattedAppointment = [
                'id' => $appointment['id'],
                'tracking_number' => $appointment['tracking_number'],
                'date' => date('F j, Y', strtotime($appointment['appointment_date'])),
                'time' => date('g:i A', strtotime($appointment['appointment_time'])),
                'reason' => $appointment['reason'] ?? 'General Consultation',
                'status' => $appointment['status'] ?? 'scheduled',
                'created_at' => date('F j, Y', strtotime($appointment['created_at'])),
                'updated_at' => date('F j, Y', strtotime($appointment['updated_at'] ?? $appointment['created_at'])),
                'special_instructions' => $appointment['special_instructions'] ?? '',
                'location' => $appointment['location'] ?? 'Main Clinic',
                'doctor' => [
                    'id' => $doctor['id'] ?? null,
                    'name' => $doctorName,
                    'specialization' => $doctor['specialization'] ?? 'Not specified'
                ]
            ];
            
            // Return success response with appointment data
            $this->jsonResponse([
                'success' => true,
                'appointment' => $formattedAppointment
            ]);
        } catch (\Exception $e) {
            // Return a JSON error response
            $this->jsonResponse([
                'success' => false,
                'message' => 'An error occurred while processing your request'
            ]);
        }
    }
    
    /**
     * Send a JSON response
     * 
     * @param array $data Data to be encoded as JSON
     * @return void
     */
    private function jsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Get available time slots for a specific doctor on a specific date
     * Updated to use query parameters
     */
    public function get_available_time_slots() {
        // Check if this is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            header('Location: ' . BASE_URL . '/appointment/doctor-availability');
            exit;
        }

        try {
            // Get parameters from query string
            $doctorId = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : null;
            $date = isset($_GET['date']) ? $_GET['date'] : null;
            
            // Debug log
            error_log("Fetching time slots for doctor ID: $doctorId, date: $date");
            
            // Validate inputs
            if (empty($doctorId) || empty($date)) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Doctor ID and date are required'
                ]);
                return;
            }

            // Get day of week from date
            $dayOfWeek = date('l', strtotime($date)); // Returns Monday, Tuesday, etc.
            error_log("Day of week for $date: $dayOfWeek");
        
            // Also get numeric day of week for verification
            $numericDayOfWeek = date('w', strtotime($date)); // 0 (Sunday) through 6 (Saturday)
            error_log("Numeric day of week for $date: $numericDayOfWeek (0=Sunday, 1=Monday, etc.)");

            // Get doctor's time slots for this day
            $timeSlots = $this->timeSlotModel->getTimeSlotsByDoctorAndDay($doctorId, $dayOfWeek);
            error_log("Found " . count($timeSlots) . " time slots for doctor $doctorId on $dayOfWeek");
            
            // If no time slots found, check if the doctor exists and has any time slots
            if (count($timeSlots) == 0) {
                $doctor = $this->doctorModel->getDoctorById($doctorId);
                if (!$doctor) {
                    error_log("Doctor with ID $doctorId does not exist");
                } else {
                    error_log("Doctor exists: " . $doctor->first_name . " " . $doctor->last_name);
                    
                    // Check all time slots for this doctor
                    $allTimeSlots = $this->timeSlotModel->getTimeSlotsByDoctorId($doctorId);
                    error_log("Doctor has " . count($allTimeSlots) . " time slots in total");
                    
                    // Log each time slot
                    foreach ($allTimeSlots as $slot) {
                        error_log("Time slot: day=" . $slot->day . ", start=" . $slot->start_time . ", end=" . $slot->end_time);
                    }
                }
            }
            
            // Get existing appointments for this doctor on this date
            $existingAppointments = $this->appointmentModel->getAppointmentsByDoctorAndDate($doctorId, $date);
            error_log("Found " . count($existingAppointments) . " existing appointments for doctor $doctorId on $date");
            
            // Format existing appointments into a simple array of times
            $bookedTimes = [];
            foreach ($existingAppointments as $appointment) {
                $bookedTimes[] = date('H:i', strtotime($appointment->appointment_time));
            }
            
            // Format available time slots
            $availableTimeSlots = [];
            foreach ($timeSlots as $slot) {
                // Debug log
                error_log("Processing time slot: " . json_encode($slot));
                
                // Generate 15-minute intervals between start and end time
                $startTime = strtotime($slot->start_time);
                $endTime = strtotime($slot->end_time);
                
                for ($time = $startTime; $time < $endTime; $time += 15 * 60) {
                    $formattedTime = date('H:i', $time);
                    
                    // Check if this time is already booked
                    if (!in_array($formattedTime, $bookedTimes)) {
                        $availableTimeSlots[] = [
                            'time' => $formattedTime,
                            'formatted_time' => date('g:i A', $time)
                        ];
                    }
                }
            }
            
            error_log("Returning " . count($availableTimeSlots) . " available time slots");
            
            $this->jsonResponse([
                'success' => true,
                'time_slots' => $availableTimeSlots,
                'debug' => [
                    'doctor_id' => $doctorId,
                    'date' => $date,
                    'day_of_week' => $dayOfWeek,
                    'numeric_day_of_week' => $numericDayOfWeek,
                    'time_slots_count' => count($timeSlots),
                    'booked_times' => $bookedTimes
                ]
            ]);
        } catch (\Exception $e) {
            error_log("Error in get_available_time_slots: " . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'An error occurred while retrieving time slots',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Book an appointment
     */
    public function book_appointment() {
        // Ensure session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if this is a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/appointment/doctor-availability');
            exit;
        }

        try {
            // Get form data
            $doctorId = isset($_POST['doctor_id']) ? trim($_POST['doctor_id']) : '';
            $appointmentDate = isset($_POST['appointment_date']) ? trim($_POST['appointment_date']) : '';
            $appointmentTime = isset($_POST['appointment_time']) ? trim($_POST['appointment_time']) : '';
            $firstName = isset($_POST['firstName']) ? trim($_POST['firstName']) : '';
            $middleName = isset($_POST['middleName']) ? trim($_POST['middleName']) : '';
            $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
            $suffix = isset($_POST['suffix']) ? trim($_POST['suffix']) : '';
            $appointmentType = isset($_POST['appointmentType']) ? trim($_POST['appointmentType']) : '';
            $appointmentReason = isset($_POST['appointmentReason']) ? trim($_POST['appointmentReason']) : '';
            $dateOfBirth = isset($_POST['dateOfBirth']) ? trim($_POST['dateOfBirth']) : '';
            $legalSex = isset($_POST['legalSex']) ? trim($_POST['legalSex']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $contactNumber = isset($_POST['contactNumber']) ? trim($_POST['contactNumber']) : '';
            $address = isset($_POST['address']) ? trim($_POST['address']) : '';
            $isGuardian = isset($_POST['isGuardian']) ? true : false;
            $guardianName = isset($_POST['guardianName']) ? trim($_POST['guardianName']) : '';
            $relationship = isset($_POST['relationship']) ? trim($_POST['relationship']) : '';

            // Debug log
            error_log("Booking appointment with data: " . json_encode([
                'doctor_id' => $doctorId,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $appointmentTime,
                'firstName' => $firstName,
                'surname' => $surname,
                'email' => $email
            ]));

            // Validate required fields
            if (empty($doctorId) || empty($appointmentDate) || empty($appointmentTime) || 
                empty($firstName) || empty($surname) || empty($appointmentType) || 
                empty($dateOfBirth) || empty($legalSex) || empty($email) || 
                empty($contactNumber) || empty($address)) {
                
                error_log("Validation failed: Missing required fields");
                
                // Redirect back with error message
                $_SESSION['error'] = 'Please fill in all required fields';
                header('Location: ' . BASE_URL . '/appointment/scheduling?doctor_id=' . $doctorId);
                exit;
            }

            // Validate guardian fields if isGuardian is checked
            if ($isGuardian && (empty($guardianName) || empty($relationship))) {
                error_log("Validation failed: Missing guardian fields");
                
                // Redirect back with error message
                $_SESSION['error'] = 'Please fill in all guardian fields';
                header('Location: ' . BASE_URL . '/appointment/scheduling?doctor_id=' . $doctorId);
                exit;
            }

            // Check if patient already exists by email
            $patient = $this->patientModel->getPatientByEmail($email);
            
            // If patient doesn't exist, create a new one
            if (!$patient) {
                error_log("Patient with email $email not found. Creating new patient.");
                
                $patientData = [
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $surname,
                    'suffix' => $suffix,
                    'date_of_birth' => $dateOfBirth,
                    'gender' => $legalSex,
                    'email' => $email,
                    'contact_number' => $contactNumber,
                    'address' => $address,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $patientId = $this->patientModel->insert($patientData);
                
                if (!$patientId) {
                    error_log("Failed to create patient record");
                    
                    // Redirect back with error message
                    $_SESSION['error'] = 'Failed to create patient record';
                    header('Location: ' . BASE_URL . '/appointment/scheduling?doctor_id=' . $doctorId);
                    exit;
                }
                
                error_log("New patient created with ID: $patientId");
            } else {
                $patientId = $patient->id;
                error_log("Existing patient found with ID: $patientId");
            }
            
            // Generate tracking number
            $trackingNumber = 'APT-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
            error_log("Generated tracking number: $trackingNumber");
            
            // Create appointment
            $appointmentData = [
                'patient_id' => $patientId,
                'doctor_id' => $doctorId,
                'appointment_date' => $appointmentDate,
                'appointment_time' => $appointmentTime,
                'reason' => $appointmentReason,
                'appointment_type' => $appointmentType,
                'status' => 'pending',
                'tracking_number' => $trackingNumber,
                'special_instructions' => '',
                // Remove guardian fields as they don't exist in the database
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // If booking as guardian, log it but don't try to save to non-existent columns
            if ($isGuardian && !empty($guardianName) && !empty($relationship)) {
                error_log("Guardian information provided but not saved (columns don't exist): Guardian: $guardianName, Relationship: $relationship");
                // Store in session for display purposes if needed
                $_SESSION['guardian_info'] = [
                    'name' => $guardianName,
                    'relationship' => $relationship
                ];
            }
            
            error_log("Creating appointment with data: " . json_encode($appointmentData));
            
            $appointmentId = $this->appointmentModel->insert($appointmentData);
            
            if (!$appointmentId) {
                error_log("Failed to create appointment");
                
                // Redirect back with error message
                $_SESSION['error'] = 'Failed to create appointment';
                header('Location: ' . BASE_URL . '/appointment/scheduling?doctor_id=' . $doctorId);
                exit;
            }
            
            error_log("Appointment created successfully with ID: $appointmentId");
            
            // Verify the appointment was created with the correct tracking number
            $createdAppointment = $this->appointmentModel->getAppointmentById($appointmentId);
            
            if (!$createdAppointment) {
                error_log("Could not find the created appointment with ID: $appointmentId");
                $_SESSION['error'] = 'Could not verify appointment creation';
                header('Location: ' . BASE_URL . '/appointment/scheduling?doctor_id=' . $doctorId);
                exit;
            }
            
            error_log("Appointment verification - ID: $appointmentId, Tracking Number in DB: " . $createdAppointment->tracking_number);
            
            // Use the tracking number from the database
            $trackingNumber = $createdAppointment->tracking_number;
            
            // Get doctor details
            $doctor = $this->doctorModel->getDoctorById($createdAppointment->doctor_id);
            
            if (!$doctor) {
                error_log("Could not find doctor with ID: " . $createdAppointment->doctor_id);
                $_SESSION['error'] = 'Could not find doctor details';
                header('Location: ' . BASE_URL . '/appointment/scheduling?doctor_id=' . $doctorId);
                exit;
            }
            
            // Add full_name property to doctor object
            $doctor->full_name = $this->doctorModel->getFullName($doctor);
            error_log("Doctor full name: " . $doctor->full_name);
            
            // Get patient details
            $patient = $this->patientModel->getPatientById($createdAppointment->patient_id);
            
            if (!$patient) {
                error_log("Could not find patient with ID: " . $createdAppointment->patient_id);
                
                // Create a dummy patient object with the form data
                $patient = (object) [
                    'id' => $patientId,
                    'first_name' => $firstName,
                    'middle_name' => $middleName,
                    'last_name' => $surname,
                    'suffix' => $suffix,
                    'email' => $email,
                    'contact_number' => $contactNumber
                ];
                
                error_log("Created dummy patient object with first_name: " . $patient->first_name);
            }
            
            // Render confirmation view directly
            $this->view('pages/appointment/confirmation.view', [
                'title' => 'Appointment Confirmation',
                'appointment' => $createdAppointment,
                'doctor' => $doctor,
                'patient' => $patient,
                'tracking_number' => $trackingNumber
            ]);
            exit;
            
        } catch (\Exception $e) {
            error_log("Error in book_appointment: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            
            // Redirect back with error message
            $_SESSION['error'] = 'An error occurred while booking the appointment: ' . $e->getMessage();
            header('Location: ' . BASE_URL . '/appointment/scheduling?doctor_id=' . (isset($_POST['doctor_id']) ? $_POST['doctor_id'] : ''));
            exit;
        }
    }

    /**
     * Show appointment confirmation page
     */
    public function confirmation() {
        // Ensure session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        error_log("Confirmation method called");
        $trackingNumber = isset($_SESSION['tracking_number']) ? $_SESSION['tracking_number'] : '';
        error_log("Tracking number from session: " . $trackingNumber);
        
        if (empty($trackingNumber)) {
            error_log("Tracking number is empty, redirecting to doctor-availability");
            header('Location: ' . BASE_URL . '/appointment/doctor-availability');
            exit;
        }
        
        // Get appointment details
        $appointment = $this->appointmentModel->getAppointmentByTrackingNumber($trackingNumber);
        
        if (!$appointment) {
            header('Location: ' . BASE_URL . '/appointment/doctor-availability');
            exit;
        }
        
        // Get doctor details
        $doctor = $this->doctorModel->getDoctorById($appointment->doctor_id);
        
        if ($doctor) {
            // Add full_name property to doctor object
            $doctor->full_name = $this->doctorModel->getFullName($doctor);
        } else {
            // Create a dummy doctor object if not found
            $doctor = (object) [
                'id' => $appointment->doctor_id,
                'full_name' => 'Unknown Doctor',
                'specialization' => 'Not specified'
            ];
        }
        
        // Get patient details
        $patient = $this->patientModel->getPatientById($appointment->patient_id);
        
        if (!$patient) {
            // Create a dummy patient object if not found
            $patient = (object) [
                'id' => $appointment->patient_id,
                'first_name' => 'Unknown',
                'last_name' => 'Patient',
                'email' => '',
                'contact_number' => ''
            ];
        }
        
        $this->view('pages/appointment/confirmation.view', [
            'title' => 'Appointment Confirmation',
            'appointment' => $appointment,
            'doctor' => $doctor,
            'patient' => $patient,
            'tracking_number' => $trackingNumber
        ]);
        
        // Clear session data
        unset($_SESSION['tracking_number']);
        unset($_SESSION['success']);
    }
}

