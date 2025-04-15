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
use app\models\Diagnosis;

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
    private $diagnosisModel;

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
        $this->diagnosisModel = new Diagnosis();
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
        $patientId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $patient = $this->patientModel->getPatientById($patientId);

        if (!$patient) {
            $this->redirect('/doctor/patient-list');
            return;
        }

        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        $this->view('pages/doctor/check-up.view', [
            'title' => 'Check Up',
            'patient' => $patient,
        ]);
    }

    public function saveCheckup()
    {
        // Check if this is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            $this->redirect('/doctor/dashboard');
            return;
        }

        $doctorId = $_SESSION['doctor_id'] ?? null;

        if (!$doctorId) {
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
            return;
        }

        // Get JSON data from request
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        if (!$data) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid data format'
            ]);
            return;
        }

        // Extract data
        $patientId = $data['patient_id'] ?? 0;
        $vitals = $data['vitals'] ?? null;
        $medications = $data['medications'] ?? [];
        $diagnoses = $data['diagnoses'] ?? [];

        try {
            // Save vitals if provided
            if ($vitals) {
                $vitalsData = [
                    'blood_pressure' => $vitals['blood_pressure'] ?? null,
                    'temperature' => $vitals['temperature'] ?? null,
                    'heart_rate' => $vitals['heart_rate'] ?? null,
                    'respiratory_rate' => $vitals['respiratory_rate'] ?? null,
                    'oxygen_saturation' => $vitals['oxygen_saturation'] ?? null,
                    'glucose_level' => $vitals['glucose_level'] ?? null,
                    'weight' => $vitals['weight'] ?? null,
                    'height' => $vitals['height'] ?? null
                ];

                $vitalsSuccess = $this->vitalsModel->addVitals($patientId, $vitalsData);

                if (!$vitalsSuccess) {
                    throw new \Exception('Failed to save vitals data');
                }
            }

            if (!empty($medications)) {
                foreach ($medications as $medication) {
                    $medicationData = [
                        'patient_id' => $patientId,
                        'medicine_id' => $medication['medicine_inventory_id'],
                        'dosage' => $medication['dosage'],
                        'frequency' => $medication['frequency'],
                        'start_date' => $medication['start_date'],
                        'prescribed_by' => $doctorId,
                        'status' => 'active',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $medicationId = $this->medicationsModel->insert($medicationData);

                    if (!$medicationId) {
                        throw new \Exception('Failed to save medication data');
                    }
                    $medicine = $this->medicineInventoryModel->getMedicineById($medication['medicine_inventory_id']);
                    if ($medicine) {
                        $previousStock = $medicine->stock_level;
                        $newStock = $previousStock - 1;


                        if (!$this->medicineInventoryModel->updateStock($medicine->id, $newStock)) {
                            throw new \Exception('Failed to update medicine stock');
                        }

                        // Add to medicine logs
                        $logData = [
                            'medicine_id' => $medicine->id,
                            'patient_id' => $patientId,
                            'doctor_id' => $doctorId,
                            'quantity' => 1,
                            'previous_stock' => $previousStock,
                            'new_stock' => $newStock,
                            'remarks' => "Prescribed: {$medication['dosage']} - {$medication['frequency']}"
                        ];

                        if (!$this->medicineLogsModel->insert($logData)) {
                            throw new \Exception('Failed to create medicine log');
                        }

                        // Create medical record entry for this medication
                        $medicalRecordData = [
                            'patient_id' => $patientId,
                            'doctor_id' => $doctorId,
                            'medication_id' => $medicationId,
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        if (!$this->medicalRecordsModel->insert($medicalRecordData)) {
                            throw new \Exception('Failed to create medical record for medication');
                        }
                    }
                }
            }

            // Save diagnoses if provided
            if (!empty($diagnoses)) {
                foreach ($diagnoses as $diagnosis) {
                    $diagnosisData = [
                        'patient_id' => $patientId,
                        'diagnosis' => $diagnosis['title'],
                        'notes' => $diagnosis['description'],
                        'doctor_id' => $doctorId,
                        'diagnosed_at' => date('Y-m-d H:i:s')
                    ];

                    $diagnosisId = $this->diagnosisModel->insert($diagnosisData);

                    if (!$diagnosisId) {
                        throw new \Exception('Failed to save diagnosis data');
                    }
                }
            }

            // Create a medical record entry for this checkup
            $recordData = [
                'patient_id' => $patientId,
                'doctor_id' => $doctorId,
                'record_type' => 'checkup',
                'record_date' => date('Y-m-d H:i:s'),
                'notes' => 'Regular checkup',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $recordId = $this->medicalRecordsModel->insert($recordData);

            if (!$recordId) {
                throw new \Exception('Failed to create medical record');
            }

            // Commit transaction
            // $this->db->commit();

            echo json_encode([
                'success' => true,
                'message' => 'Checkup data saved successfully'
            ]);
        } catch (\Exception $e) {
            // Rollback transaction on error
            // $this->db->rollback();

            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }



    public function getMedicineCategories()
    {
        // Check if this is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            $this->redirect('/doctor/dashboard');
            return;
        }

        $doctorId = $_SESSION['doctor_id'] ?? null;

        if (!$doctorId) {
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
            return;
        }

        // Get all distinct medicine categories
        $categories = $this->medicineInventoryModel->getAllMedicineCategories();

        echo json_encode([
            'success' => true,
            'categories' => $categories
        ]);
    }

    public function searchMedicines()
    {
        // Check if this is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            $this->redirect('/doctor/dashboard');
            return;
        }

        $doctorId = $_SESSION['doctor_id'] ?? null;

        if (!$doctorId) {
            echo json_encode([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
            return;
        }

        // Get search parameters
        $category = $_GET['category'] ?? '';
        $searchTerm = $_GET['search'] ?? '';

        // Search medicines based on category and search term
        $medicines = $this->medicineInventoryModel->searchMedicines($category, $searchTerm);

        // Filter out medicines with zero stock
        $availableMedicines = array_filter($medicines, function ($medicine) {
            return $medicine->stock_level > 0 && $medicine->status === 'Available';
        });

        echo json_encode([
            'success' => true,
            'medicines' => $availableMedicines
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


    public function appointments()
    {
        $doctorId = $_SESSION['doctor_id'] ?? null;

        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        $appointments = $this->appointmentModel->getAppointmentsByDoctorId($doctorId);

        $this->view('pages/doctor/appointments.view', [
            'title' => 'Appointments',
            'appointments' => $appointments
        ]);
    }

    public function prescriptions()
    {
        $doctorId = $_SESSION['doctor']['id'] ?? null;
        $patientId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        $patient = $this->patientModel->getPatientById($patientId);
        $vitals = $this->vitalsModel->getLatestVitalsByPatientId($patientId);

        $this->view('pages/doctor/prescription.view', [
            'title' => 'Create Prescription',
            'patient' => $patient,
            'vitals' => $vitals
        ]);
    }

    public function previewPrescription()
    {
        $doctorId = $_SESSION['doctor']['id'] ?? null;
        if (!$doctorId) {
            $this->redirect('/doctor');
            return;
        }

        // Get form data
        $patientId = $_POST['patient_id'] ?? 0;
        $medications = $_POST['medications'] ?? [];
        $advice = $_POST['advice'] ?? '';
        $followupDate = $_POST['followup_date'] ?? '';
        $prescriptionDate = $_POST['prescription_date'] ?? date('d-M-Y');

        // Get patient and vitals data
        $patient = $this->patientModel->getPatientById($patientId);
        $vitals = $this->vitalsModel->getLatestVitalsByPatientId($patientId);

        if (!$patient) {
            $this->redirect('/doctor/patients');
            return;
        }

        $this->view('pages/doctor/preview-prescription.view', [
            'title' => 'Preview Prescription',
            'patient' => $patient,
            'vitals' => $vitals,
            'medications' => $medications,
            'advice' => $advice,
            'followup_date' => $followupDate,
            'prescription_date' => $prescriptionDate
        ]);
    }
}