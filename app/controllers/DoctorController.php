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
use app\models\EPrescription;
use app\models\EPrescriptionMedicines;
use app\models\TreatmentRecords;
use app\helpers\email\PrescriptionEmail;
use app\models\PatientAdmission;
use app\models\Vaccines;


class DoctorController extends Controller
{
    private $doctorModel;
    private $ePrescriptionModel;
    private $ePrescriptionMedicinesModel;
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
    private $treatmentRecordsModel;
    private $patientAdmissionModel;
    private $prescriptionEmailHelper;
    private $vaccinesModel;

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
        $this->ePrescriptionModel = new EPrescription();
        $this->ePrescriptionMedicinesModel = new EPrescriptionMedicines();
        $this->prescriptionEmailHelper = new PrescriptionEmail();
        $this->treatmentRecordsModel = new TreatmentRecords();
        $this->patientAdmissionModel = new PatientAdmission();
        $this->vaccinesModel = new Vaccines();
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

        // Get prescriptions data
        $prescriptions = $this->ePrescriptionModel->getPrescriptionsForPatient($patientId);
        foreach ($prescriptions as &$prescription) {
            $prescription->medications = $this->ePrescriptionMedicinesModel->getMedicationsForPrescription($prescription->id);
        }

        $vitals = $this->vitalsModel->getLatestVitalsByPatientId($patientId);
        $visits = $this->medicalRecordsModel->getPatientVisitsWithDetails($patientId);
        $appointments = $this->appointmentModel->getAppointmentsByPatientId($patientId);
        $recentVisits = $this->appointmentModel->getRecentVisitsByPatientsAssignedToDoctor(
            $_SESSION['doctor_id'],
            10
        );
        $treatmentRecords = $this->treatmentRecordsModel->getPatientTreatmentRecords($patientId);
        $immunizationHistory = $this->immunizationModel->getPatientImmunizations($patientId);
        $patientLabResults = $this->labResultsModel->getPatientLabResults($patientId);

        $admissionHistory = $this->patientAdmissionModel->getPatientAdmissions($patientId);
        $patientDiagnosis = $this->diagnosisModel->getPatientDiagnoses($patientId);

        $vaccines = $this->vaccinesModel->getAllVaccines();

        $this->view('pages/doctor/patient-view', [
            'title' => 'Patient Record',
            'patient' => $patient,
            'vitals' => $vitals,
            'visits' => $visits,
            'appointments' => $appointments,
            'recentVisits' => $recentVisits,
            'prescriptions' => $prescriptions,
            'immunizationHistory' => $immunizationHistory,
            'patientLabResults' => $patientLabResults,
            'treatmentRecords' => $treatmentRecords,
            'admissionHistory' => $admissionHistory,
            'patientDiagnosis' => $patientDiagnosis,
            'vaccines' => $vaccines,
        ]);
    }

    public function admissionDetails()
    {
        $admissionId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (!$admissionId) {
            $this->redirect('/doctor/patients');
            return;
        }

        $admission = $this->patientAdmissionModel->getAdmissionById($admissionId);
        if (!$admission) {
            $this->redirect('/doctor/patients');
            return;
        }

        $patient = $this->patientModel->getPatientById($admission->patient_id);
        $admissionHistory = $this->patientAdmissionModel->getPatientAdmissions($admission->patient_id);

        // Get admission statistics
        $stats = [
            'total' => count($admissionHistory),
            'active' => count(array_filter($admissionHistory, fn($r) => strtolower($r->status) === 'admitted')),
            'discharged' => count(array_filter($admissionHistory, fn($r) => strtolower($r->status) === 'discharged'))
        ];

        $this->view('pages/doctor/admission-details.view', [
            'title' => 'Admission Details',
            'patient' => $patient,
            'currentAdmission' => $admission,
            'admissionHistory' => $admissionHistory,
            'stats' => $stats
        ]);
    }


    public function saveImmunization()
    {
        try {
            // Set headers to prevent any output before JSON
            ob_clean(); // Clear any previous output
            header('Content-Type: application/json');

            if (!isset($_SESSION['doctor']['id'])) {
                throw new \Exception('Doctor session not found');
            }

            $doctorId = $_SESSION['doctor']['id'];

            // Prepare immunization data
            $immunizationData = [
                'patient_id' => $_POST['patient_id'] ?? null,
                'doctor_id' => $doctorId,
                'vaccine_id' => $_POST['vaccine_id'] ?? null,
                'immunization_date' => $_POST['immunization_date'] ?? null,
                'administrator' => $_POST['administrator'] ?? null,
                'lot_number' => $_POST['lot_number'] ?? null,
                'next_date' => !empty($_POST['next_date']) ? $_POST['next_date'] : null,
                'notes' => $_POST['notes'] ?? null
            ];

            // Validate required fields
            foreach (['patient_id', 'doctor_id', 'vaccine_id', 'immunization_date', 'administrator', 'lot_number'] as $field) {
                if (empty($immunizationData[$field])) {
                    throw new \Exception("Missing required field: $field");
                }
            }

            // Insert immunization record
            $immunizationId = $this->immunizationModel->insert($immunizationData);

            if (!$immunizationId) {
                throw new \Exception('Failed to save immunization record');
            }

            // Create medical record entry
            $medicalRecordData = [
                'patient_id' => $immunizationData['patient_id'],
                'doctor_id' => $doctorId,
                'record_type' => 'Immunization',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->medicalRecordsModel->insert($medicalRecordData);

            echo json_encode([
                'success' => true,
                'message' => 'Immunization record saved successfully',
                'immunizationId' => $immunizationId
            ]);

        } catch (\Exception $e) {
            error_log('Immunization Save Error: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }



    public function saveAdmission()
    {
        try {
            // Set headers to prevent any output before JSON
            ob_clean(); // Clear any previous output
            header('Content-Type: application/json');

            if (!isset($_SESSION['doctor']['id'])) {
                throw new \Exception('Doctor session not found');
            }

            $doctorId = $_SESSION['doctor']['id'];

            // Prepare admission data
            $admissionData = [
                'patient_id' => $_POST['patient_id'] ?? null,
                'diagnosis_id' => $_POST['diagnosis_id'] ?? null,
                'admitted_by' => $doctorId,
                'admission_date' => $_POST['admission_date'] ?? null,
                'reason' => $_POST['reason'] ?? null,
                'ward' => $_POST['ward'] ?? null,
                'bed_no' => $_POST['bed_no'] ?? null,
                'status' => 'admitted'
            ];

            // Validate required fields
            foreach ($admissionData as $key => $value) {
                if ($value === null && $key !== 'status') {
                    throw new \Exception("Missing required field: $key");
                }
            }

            // Insert admission record
            $admissionId = $this->patientAdmissionModel->insert($admissionData);

            if (!$admissionId) {
                throw new \Exception('Failed to save admission record');
            }

            // Create medical record entry
            $medicalRecordData = [
                'patient_id' => $admissionData['patient_id'],
                'doctor_id' => $doctorId,
                'diagnosis_id' => $admissionData['diagnosis_id'],
                'admission_id' => $admissionId,
                'record_type' => 'Admission',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->medicalRecordsModel->insert($medicalRecordData);

            echo json_encode([
                'success' => true,
                'message' => 'Admission record saved successfully',
                'admissionId' => $admissionId
            ]);

        } catch (\Exception $e) {
            error_log('Admission Save Error: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    public function updateAdmissionStatus()
    {
        try {
            ob_clean();
            header('Content-Type: application/json');

            if (!isset($_SESSION['doctor']['id'])) {
                throw new \Exception('Doctor session not found');
            }

            $result = $this->patientAdmissionModel->updateStatus($_POST);

            if (isset($result['error'])) {
                throw new \Exception($result['error']);
            }

            echo json_encode([
                'success' => true,
                'message' => 'Admission status updated successfully'
            ]);

        } catch (\Exception $e) {
            error_log('Admission Status Update Error: ' . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }




    public function immunizationDetails()
    {
        $immunizationId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (!$immunizationId) {
            $this->redirect('/doctor/patients');
            return;
        }

        $immunization = $this->immunizationModel->getImmunizationById($immunizationId);
        if (!$immunization) {
            $this->redirect('/doctor/patients');
            return;
        }

        $patient = $this->patientModel->getPatientById($immunization->patient_id);
        $immunizationHistory = $this->immunizationModel->getPatientImmunizations($immunization->patient_id);

        // Get immunization statistics
        $stats = [
            'total' => count($immunizationHistory),
            'recent' => count(array_filter($immunizationHistory, function ($r) {
                return strtotime($r->immunization_date) > strtotime('-6 months');
            })),
            'upcoming' => count(array_filter($immunizationHistory, function ($r) {
                return !empty($r->next_date) && strtotime($r->next_date) > time();
            }))
        ];

        $this->view('pages/doctor/immunization-details.view', [
            'title' => 'Immunization Details',
            'patient' => $patient,
            'currentImmunization' => $immunization,
            'immunizationHistory' => $immunizationHistory,
            'stats' => $stats
        ]);
    }

    public function prescriptionDetails()
    {
        $prescriptionId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (!$prescriptionId) {
            $this->redirect('/doctor/patients');
            return;
        }

        $prescription = $this->ePrescriptionModel->getPrescriptionWithDetails($prescriptionId);
        if (!$prescription) {
            $this->redirect('/doctor/patients');
            return;
        }

        $patient = $this->patientModel->getPatientById($prescription->patient_id);
        $medications = $this->ePrescriptionMedicinesModel->getMedicationsForPrescription($prescriptionId);
        $prescriptionHistory = $this->ePrescriptionModel->getPrescriptionsForPatient($prescription->patient_id);

        // Get prescription statistics
        $stats = [
            'total' => count($prescriptionHistory),
            'recent' => count(array_filter($prescriptionHistory, function ($r) {
                return strtotime($r->created_at) > strtotime('-30 days');
            })),
            'medications' => count($medications)
        ];

        $this->view('pages/doctor/prescription-details.view', [
            'title' => 'Prescription Details',
            'patient' => $patient,
            'prescription' => $prescription,
            'medications' => $medications,
            'prescriptionHistory' => $prescriptionHistory,
            'stats' => $stats
        ]);
    }


    public function treatmentDetails()
    {
        $treatmentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (!$treatmentId) {
            $this->redirect('/doctor/patients');
            return;
        }

        $treatment = $this->treatmentRecordsModel->getTreatmentById($treatmentId);
        if (!$treatment) {
            $this->redirect('/doctor/patients');
            return;
        }

        $patient = $this->patientModel->getPatientById($treatment->patient_id);
        $treatmentRecords = $this->treatmentRecordsModel->getPatientTreatmentRecords($treatment->patient_id);

        // Get treatment statistics
        $stats = [
            'total' => count($treatmentRecords),
            'active' => count(array_filter($treatmentRecords, fn($r) => strtolower($r->status) === 'active')),
            'completed' => count(array_filter($treatmentRecords, fn($r) => strtolower($r->status) === 'completed')),
            'goodAdherence' => count(array_filter($treatmentRecords, fn($r) => strtolower($r->adherence_status) === 'good'))
        ];

        $this->view('pages/doctor/treatment-details.view', [
            'title' => 'Treatment Details',
            'patient' => $patient,
            'currentTreatment' => $treatment,
            'treatmentRecords' => $treatmentRecords,
            'stats' => $stats
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

    public function savePrescription()
    {
        header('Content-Type: application/json');

        try {
            if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
                throw new \Exception('Invalid request method');
            }

            $doctorId = $_SESSION['doctor']['id'] ?? null;
            if (!$doctorId) {
                throw new \Exception('Unauthorized access');
            }

            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON data: ' . json_last_error_msg());
            }

            if (!isset($data['patientId'])) {
                throw new \Exception('Patient ID is required');
            }

            // First, save the prescription to get the ID
            $prescriptionCode = 'RX-' . date('Ymd') . '-' . uniqid();
            $prescriptionData = [
                'prescription_code' => $prescriptionCode,
                'patient_id' => $data['patientId'],
                'doctor_id' => $doctorId,
                'vitals_id' => $data['vitalsId'] ?? null,
                'diagnosis' => $data['diagnosis'] ?? '',
                'advice' => $data['advice'] ?? '',
                'follow_up_date' => $data['followUpDate'] ?? null,
                'created_at' => date('Y-m-d H:i:s'),
                // 'status' => 'active'
            ];

            // Insert prescription and get the ID
            $prescriptionId = $this->ePrescriptionModel->insert($prescriptionData);

            if (!$prescriptionId) {
                echo json_encode(['success' => false, 'message' => 'Failed to save prescription']);
                return;
            }

            // Now save the medications with the prescription ID
            if (!empty($data['medications'])) {
                $success = $this->ePrescriptionMedicinesModel->insertBatch($prescriptionId, $data['medications']);

                if (!$success) {
                    $this->ePrescriptionModel->delete($prescriptionId);
                    echo json_encode(['success' => false, 'message' => 'Failed to save medications']);
                    return;
                }
            }

            echo json_encode([
                'success' => true,
                'message' => 'Prescription saved successfully',
                'prescriptionId' => $prescriptionId
            ]);

        } catch (\Exception $e) {
            error_log("Prescription Save Error: " . $e->getMessage());

            echo json_encode([
                'success' => false,
                'message' => 'Failed to save prescription: ' . $e->getMessage(),
                'error' => [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]
            ]);
        }
    }

    public function emailPrescription()
    {
        if (!$this->isAjaxRequest()) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
            return;
        }

        try {
            $jsonData = file_get_contents('php://input');
            $data = json_decode($jsonData, true);

            if (!$data) {
                throw new \Exception('Invalid request data');
            }

            $patientId = $data['patientId'] ?? null;
            $prescriptionImage = $data['prescriptionImage'] ?? null;
            $includeInstructions = $data['includeInstructions'] ?? true;
            $additionalMessage = $data['additionalMessage'] ?? '';

            if (!$patientId || !$prescriptionImage) {
                throw new \Exception('Missing required data');
            }

            // Get patient details
            $patient = $this->patientModel->getPatientById($patientId);
            if (!$patient || !$patient->email) {
                throw new \Exception('Patient email not found');
            }


            $prescriptionEmail = new PrescriptionEmail();

            $emailSent = $prescriptionEmail->sendPrescription(
                $patient->email,
                $patient->first_name . ' ' . $patient->last_name,
                $prescriptionImage,
                $additionalMessage,
                $includeInstructions
            );

            if (!$emailSent) {
                throw new \Exception('Failed to send email');
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Prescription has been emailed successfully'
            ]);

        } catch (\Exception $e) {
            error_log('Email Prescription Error: ' . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }






    private function isAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }



    private function prepareJsonResponse()
    {
        // Disable error output to prevent it from corrupting JSON
        ini_set('display_errors', 0);
        error_reporting(0);

        // Start output buffering to capture any unexpected output

        ob_start();
    }

    /**
     * Get JSON request data
     */
    private function getJsonRequestData()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        error_log('Received data: ' . print_r($data, true));
        return $data;
    }

    /**
     * JSON response helper
     */
    private function jsonResponse($data)
    {
        // Clear any previous output that might corrupt the JSON
        if (ob_get_length()) {
            ob_clean();
        }

        // Discard any output that might have been generated
        ob_end_clean();

        // Start a new buffer
        ob_start();

        // Set proper headers
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');

        // Output JSON data
        echo json_encode($data);

        // Flush the buffer and end the script
        ob_end_flush();
        exit;
    }

    /**
     * Log error with stack trace
     */
    private function logError($message, $exception)
    {
        error_log($message . ': ' . $exception->getMessage());
        error_log('Stack trace: ' . $exception->getTraceAsString());
    }

}