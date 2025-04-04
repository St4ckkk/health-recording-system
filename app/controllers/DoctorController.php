<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\Doctor;
use app\models\DoctorTimeSlot;
use app\models\Patient;
use app\models\MedicineInventory;
use app\helpers\EmailHelper;
use app\helpers\TrackingNumber;
use app\models\Vitals;
use app\models\LabResults;
use app\models\Medications;
use app\models\MedicineLogs;
use app\models\MedicalRecords;
use app\models\Immunization;

class DoctorController extends Controller
{
    private $doctorModel;
    private $patientModel;
    private $appointmentModel;
    private $medicineInventoryModel;
    private $vitalsModel;
    private $labResultsModel;
    private $medicationsModel;
    private $medicineLogsModel;
    private $medicalRecordsModel;
    private $immunizationModel;

    public function __construct()
    {
        $this->doctorModel = new Doctor();
        $this->patientModel = new Patient();
        $this->appointmentModel = new Appointment();
        $this->medicineInventoryModel = new MedicineInventory();
        $this->vitalsModel = new Vitals();
        $this->labResultsModel = new LabResults();
        $this->medicationsModel = new Medications();
        $this->medicineLogsModel = new MedicineLogs();
        $this->medicalRecordsModel = new MedicalRecords();
        $this->immunizationModel = new Immunization();
    }



    public function dashboard()
    {
        $doctorId = $_SESSION['doctor']['id'] ?? null;

        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        $appointmentModel = new Appointment();
        $patientStats = $this->doctorModel->getPatientCountChange($doctorId);
        $todayAppointmentsData = $appointmentModel->getTodayAppointmentsByDoctor($doctorId);
        $upcomingAppointmentsData = $appointmentModel->getUpcomingAppointmentsByDoctor($doctorId);
        $recentAppointments = array_slice($todayAppointmentsData['appointments'], 0, 5);
        $lowStockMedicines = $this->medicineInventoryModel->getLowStockCount();


        $this->view('pages/doctor/dashboard.view', [
            'title' => 'Doctor Dashboard',
            'totalPatients' => $patientStats['total'],
            'patientPercentage' => $patientStats['percentage'],
            'todayAppointments' => $todayAppointmentsData['total'],
            'recentAppointments' => $recentAppointments,
            'upcomingAppointments' => $upcomingAppointmentsData['appointments'],
            'lowStockCount' => $lowStockMedicines['count'],
            'lowStockItems' => $lowStockMedicines['items'],

        ]);
    }

    public function patientList()
    {
        $doctorId = $_SESSION['doctor']['id'] ?? null;  // Changed from doctor_id to doctor['id']

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


    public function patientView()
    {
        $patientId = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $doctorId = $_SESSION['doctor']['id'] ?? null;

        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        $patient = $this->patientModel->getPatientById($patientId);
        $vitals = $this->vitalsModel->getLatestVitalsByPatientId($patientId);
        $currentMedications = $this->medicationsModel->getCurrentMedicationsByPatientId($patientId);
        $medicationHistory = $this->medicationsModel->getPatientMedicationHistory($patientId);
        $immunizationHistory = $this->immunizationModel->getPatientImmunizations($patientId);
        if (!$patient) {
            $this->redirect('/doctor/patient-list');
            return;
        }

        $activeMedications = $this->medicationsModel->getPatientActiveMedications($patientId);
        $visits = $this->medicalRecordsModel->getPatientVisitsWithDetails($patientId);
        $patientLabResults = $this->labResultsModel->getPatientLabResults($patientId);
        $appointments = $this->appointmentModel->getAppointmentsByPatientId($patientId);
        $recentVisits = $this->appointmentModel->getRecentVisitsByPatientsAssignedToDoctor(
            $_SESSION['doctor_id'],
            10
        );
        $labResults = $this->labResultsModel->getRecentLabResults($patientId, 10);

        $this->view('pages/doctor/patient-view', [
            'title' => 'Patient Record',
            'patient' => $patient,
            'vitals' => $vitals,
            'visits' => $visits,
            'appointments' => $appointments,
            'recentVisits' => $recentVisits,
            'labResults' => $labResults,
            'medications' => $currentMedications,
            'patientLabResults' => $patientLabResults,
            'activeMedications' => $activeMedications,
            'medicationHistory' => $medicationHistory,
            'immunizationHistory' => $immunizationHistory,
        ]);
    }


    public function medicineInventory()
    {
        $doctorId = $_SESSION['doctor_id'] ?? null;

        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        $medicines = $this->medicineInventoryModel->getAllMedicines();
        $this->view('pages/doctor/medicine-inventory.view', [
            'title' => 'Medicine Inventory',
            'medicines' => $medicines
        ]);
    }


    public function medicineLogs()
    {
        $doctorId = $_SESSION['doctor_id'] ?? null;

        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        $medicineLogs = $this->medicineLogsModel->getMedicineLogs();

        $this->view('pages/doctor/medicine-logs.view', [
            'title' => 'Medicine Logs',
            'medicineLogs' => $medicineLogs,
        ]);
    }


    public function checkUp()
    {
        $doctorId = $_SESSION['doctor_id'] ?? null;

        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        $this->view('pages/doctor/check-up.view', [
            'title' => 'Check Up',
        ]);
    }


    public function reports()
    {
        $doctorId = $_SESSION['doctor_id'] ?? null;

        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        $visitStats = $this->appointmentModel->getMonthlyVisitStats($doctorId);
        $diagnosisStats = $this->patientModel->getDiagnosisDistribution();
        $medicineUsageStats = $this->medicineInventoryModel->getMedicineUsageStats();

        $this->view('pages/doctor/reports.view', [
            'title' => 'Reports',
            'visitStats' => $visitStats,
            'diagnosisStats' => $diagnosisStats,
            'medicineUsageStats' => $medicineUsageStats
        ]);
    }
}