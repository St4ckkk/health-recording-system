<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\Doctor;
use app\models\DoctorTimeSlot;
use app\models\Patient;
use app\models\MedicineInventory;
use app\helpers\EmailHelper;
use app\helpers\TrackingNumber;

class DoctorController extends Controller {
    private $doctorModel;
    private $medicineInventoryModel;
    
    public function __construct() {
        $this->doctorModel = new Doctor();
        $this->medicineInventoryModel = new MedicineInventory();
    }

    public function dashboard() {
        $doctorId = $_SESSION['doctor']['id'] ?? null;
        
        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        $appointmentModel = new Appointment();
        $patientStats = $this->doctorModel->getPatientCountChange($doctorId);
        $todayAppointmentsData = $appointmentModel->getTodayAppointmentsByDoctor($doctorId);
        $upcomingAppointmentsData = $appointmentModel->getUpcomingAppointmentsByDoctor($doctorId);
        $recentAppointments = array_slice($todayAppointmentsData['appointments'], 0, 5); // Get last 5 appointments
        $lowStockMedicines = $this->medicineInventoryModel->getLowStockCount();

        $this->view('pages/doctor/dashboard.view', [
            'title' => 'Doctor Dashboard',
            'totalPatients' => $patientStats['total'],
            'patientPercentage' => $patientStats['percentage'],
            'todayAppointments' => $todayAppointmentsData['total'],
            'recentAppointments' => $recentAppointments,
            'upcomingAppointments' => $upcomingAppointmentsData['appointments'],
            'lowStockCount' => $lowStockMedicines['count'],
            'lowStockItems' => $lowStockMedicines['items']
        ]);
    }
}