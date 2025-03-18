<?php

namespace app\controllers;

use app\models\Appointment;

class ReceptionistController extends Controller
{
    private $appointmentModel;

    public function __construct()
    {
        $this->appointmentModel = new Appointment();
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
        $this->view('pages/receptionist/appointments', [
            'title' => 'Appointments'
        ]);
    }

    public function notification()
    {
        $this->view('pages/receptionist/notification', [
            'title' => 'Notification'
        ]);
    }

    public function doctor_schedules()
    {
        $this->view('pages/receptionist/doctor_schedules', [
            'title' => 'Doctor Schedules'
        ]);
    }
}
