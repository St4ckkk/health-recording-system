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
     * Helper method to send JSON response
     */
    private function jsonResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
