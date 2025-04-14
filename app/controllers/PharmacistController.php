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

class PharmacistController extends Controller
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
        $lowStockMedicines = $this->medicineInventoryModel->getLowStockCount();
        $medicineStats = $this->medicineInventoryModel->getMedicineStats();
        $medicineUsage = $this->medicineInventoryModel->getMedicineUsageStats();

        $this->view('pages/pharmacist/dashboard.view', [
            'title' => 'Pharmacist Dashboard',
            'lowStockCount' => $lowStockMedicines['count'],
            'outOfStockCount' => $lowStockMedicines['out_of_stock'],
            'lowStockItems' => $lowStockMedicines['items'],
            'totalMedicines' => $medicineStats->total_medicines,
            'expiringCount' => $medicineStats->expiring_soon,
            'medicineUsage' => $medicineUsage
        ]);
    }




    public function medicineInventory()
    {
        // $doctorId = $_SESSION['doctor_id'] ?? null;

        // if (!$doctorId) {
        //     $this->redirect('/doctor');
        //     return;
        // }

        $medicines = $this->medicineInventoryModel->getAllMedicines();
        $this->view('pages/pharmacist/medicine-inventory.view', [
            'title' => 'Medicine Inventory',
            'medicines' => $medicines
        ]);
    }


    public function medicineLogs()
    {
        // $doctorId = $_SESSION['doctor_id'] ?? null;

        // if (!$doctorId) {
        //     $this->redirect('/doctor');
        //     return;
        // }

        $medicineLogs = $this->medicineLogsModel->getMedicineLogs();

        $this->view('pages/pharmacist/medicine-logs.view', [
            'title' => 'Medicine Logs',
            'medicineLogs' => $medicineLogs,
        ]);
    }


    public function updateMedicine()
    {
        if (!$this->isAjaxRequest()) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request method']);
        }

        $data = $this->getJsonRequestData();

        // Get current medicine data for stock comparison
        $currentMedicine = $this->medicineInventoryModel->getMedicineById($data['medicineId']);

        try {
            $updated = $this->medicineInventoryModel->updateMed($data);

            if ($updated) {
                // Check if stock level has changed
                if ($currentMedicine && $currentMedicine->stock_level != $data['stockLevel']) {
                    $stockDifference = $data['stockLevel'] - $currentMedicine->stock_level;

                    // Only create log if stock has changed
                    if ($stockDifference != 0) {
                        $logData = [
                            'medicine_id' => $data['medicineId'],
                            'action_type' => $stockDifference > 0 ? 'restock' : 'adjustment',
                            'quantity' => abs($stockDifference),
                            'previous_stock' => $currentMedicine->stock_level,
                            'new_stock' => $data['stockLevel'],
                            'staff_id' => $_SESSION['staff_id'] ?? null,
                            'doctor_id' => null,
                            'patient_id' => null,
                            'remarks' => $stockDifference > 0 ? 'Stock restocked' : 'Stock adjusted'
                        ];

                        $this->medicineLogsModel->insert($logData);
                    }
                }

                $this->jsonResponse(['success' => true, 'message' => 'Medicine updated successfully']);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to update medicine']);
            }
        } catch (\Exception $e) {
            error_log('Exception while updating medicine: ' . $e->getMessage());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }


    public function reports()
    {
        // Get inventory statistics
        $medicineStats = $this->medicineInventoryModel->getMedicineStats();
        $lowStockInfo = $this->medicineInventoryModel->getLowStockCount();

        // Get stock statistics for the chart
        $stockStats = (object) [
            'labels' => [],
            'current' => [],
            'minimum' => []
        ];

        $medicines = $this->medicineInventoryModel->getAllMedicines();
        foreach ($medicines as $medicine) {
            $stockStats->labels[] = $medicine->name;
            $stockStats->current[] = $medicine->stock_level;
            $stockStats->minimum[] = 10; // Minimum threshold
        }

        // Get usage statistics
        $usageStats = (object) [
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'dispensed' => [],
            'restocked' => []
        ];

        // Get expiry statistics
        $expiryStats = (object) [
            'periods' => ['This Week', 'Next Week', 'This Month', 'Next Month', '3 Months'],
            'counts' => [
                count($this->medicineInventoryModel->getExpiringSoonMedicines(7)),
                count($this->medicineInventoryModel->getExpiringSoonMedicines(14)),
                count($this->medicineInventoryModel->getExpiringSoonMedicines(30)),
                count($this->medicineInventoryModel->getExpiringSoonMedicines(60)),
                count($this->medicineInventoryModel->getExpiringSoonMedicines(90))
            ]
        ];

        $this->view('pages/pharmacist/reports.view', [
            'title' => 'Reports & Analytics',
            'medicineStats' => $medicineStats,
            'lowStockInfo' => $lowStockInfo,
            'stockStats' => $stockStats,
            'usageStats' => $usageStats,
            'expiryStats' => $expiryStats
        ]);
    }



    private function isAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private function prepareJsonResponse()
    {
        ini_set('display_errors', 0);
        error_reporting(0);
        ob_start();
    }

    private function getJsonRequestData()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        error_log('Received data: ' . print_r($data, true));
        return $data;
    }

    private function jsonResponse($data)
    {
        if (ob_get_length()) {
            ob_clean();
        }
        ob_end_clean();
        ob_start();
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, must-revalidate');
        echo json_encode($data);
        ob_end_flush();
        exit;
    }

    public function addMedicine()
    {
        if (!$this->isAjaxRequest()) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request method']);
        }

        $this->prepareJsonResponse();
        $data = $this->getJsonRequestData();

        // Log the received data
        error_log('Received medicine data: ' . print_r($data, true));

        // Validate required fields
        $requiredFields = ['medicineName', 'category', 'form', 'dosage', 'stockLevel', 'expiryDate', 'supplier', 'manufacturer'];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                $this->jsonResponse(['success' => false, 'message' => "Missing required field: {$field}"]);
            }
        }

        $medicineData = [
            'name' => $data['medicineName'],
            'category' => $data['category'],
            'form' => $data['form'],
            'dosage' => $data['dosage'],
            'stock_level' => $data['stockLevel'],
            'expiry_date' => $data['expiryDate'],
            'status' => 'Available',
            'supplier' => $data['supplier'],
            'manufacturer' => $data['manufacturer']
        ];

        try {
            // Log the data being inserted
            error_log('Attempting to insert medicine data: ' . print_r($medicineData, true));

            $medicineId = $this->medicineInventoryModel->insert($medicineData);

            if ($medicineId) {
                $logData = [
                    'medicine_id' => $medicineId,
                    'action_type' => 'restock',
                    'quantity' => $medicineData['stock_level'],
                    'previous_stock' => 0,
                    'new_stock' => $medicineData['stock_level'],
                    'staff_id' => $_SESSION['staff_id'] ?? null,
                    'doctor_id' => null,
                    'patient_id' => null,
                    'remarks' => 'Initial stock addition'
                ];

                // Log the medicine log data
                error_log('Attempting to insert medicine log: ' . print_r($logData, true));

                $this->medicineLogsModel->insert($logData);
                $this->jsonResponse(['success' => true, 'message' => 'Medicine added successfully']);
            } else {
                error_log('Failed to insert medicine: No ID returned');
                $this->jsonResponse(['success' => false, 'message' => 'Database error: Failed to add medicine']);
            }
        } catch (\Exception $e) {
            error_log('Exception while adding medicine: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
            $this->jsonResponse([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }


    public function deleteMedicine()
    {
        if (!$this->isAjaxRequest()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        $data = $this->getJsonRequestData();

        if (!isset($data['medicineId'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Medicine ID is required']);
            exit;
        }

        try {
            if ($this->medicineInventoryModel->delete($data['medicineId'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Medicine deleted successfully']);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Failed to delete medicine']);
            }
        } catch (\Exception $e) {
            error_log('Exception while deleting medicine: ' . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
        exit;
    }
}