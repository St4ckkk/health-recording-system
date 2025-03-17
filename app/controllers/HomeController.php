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

    public function scheduling()
    {
        $this->view('pages/appointment/scheduling.view', [
            'title' => 'Schedule Your Appointment'
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
}