<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\Doctor;
use app\models\DoctorTimeSlot;

class ReceptionistController extends Controller
{
    private $appointmentModel;
    private $doctorModel;
    private $timeSlotModel;

    public function __construct()
    {
        $this->appointmentModel = new Appointment();
        $this->doctorModel = new Doctor();
        $this->timeSlotModel = new DoctorTimeSlot();
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

        // Get upcoming appointments
        $upcomingAppointments = $this->appointmentModel->getUpcomingAppointments();

        // Get past appointments
        $pastAppointments = $this->appointmentModel->getPastAppointments();

        // Determine which appointments to display based on tab
        $displayAppointments = $allAppointments;
        if ($tab === 'upcoming') {
            $displayAppointments = $upcomingAppointments;
        } elseif ($tab === 'past') {
            $displayAppointments = $pastAppointments;
        }

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
}
