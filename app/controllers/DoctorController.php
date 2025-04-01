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
    private $patientModel;
    private $appointmentModel;
    private $medicineInventoryModel;
    
    public function __construct() {
        $this->doctorModel = new Doctor();
        $this->patientModel = new Patient();
        $this->appointmentModel = new Appointment();
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

    public function patientList() {
        $doctorId = $_SESSION['doctor_id'] ?? null;

        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        $patients = $this->doctorModel->getPatientsByDoctor($doctorId);

        $this->view('pages/doctor/patient-list.view', [
            'title' => 'Patient List',
            'patients' => $patients
        ]);
    }


    public function patientView() {
        $patientId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $patient = $this->patientModel->getPatientById($patientId);

        if (!$patient) {
            $this->redirect('/doctor/patient-list');
            return;
        }

        $appointments = $this->appointmentModel->getAppointmentsByPatientId($patientId);

        $this->view('pages/doctor/patient-view', [
            'title' => 'Patient Record',
            'patient' => $patient,
            'appointments' => $appointments
        ]);
    }
}