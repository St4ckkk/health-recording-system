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
use app\models\TransactionRecord;

class PharmacistController extends Controller
{
    private $transactionRecordModel;
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
        $this->transactionRecordModel = new TransactionRecord();
    }



    public function dashboard()
    {
        $lowStockMedicines = $this->medicineInventoryModel->getLowStockCount();
        $medicineStats = $this->medicineInventoryModel->getMedicineStats();
        $medicineUsage = $this->medicineInventoryModel->getMedicineUsageStats();

        // Get additional data for enhanced dashboard
        $expiringMedicines = $this->medicineInventoryModel->getExpiringMedicineDetails();
        $categoryDistribution = $this->medicineInventoryModel->getCategoryDistribution();
        $inventoryValue = $this->medicineInventoryModel->getInventoryValueStats();
        $recentTransactions = $this->medicineInventoryModel->getRecentTransactions();

        // Format expiring items for display
        $expiringItems = '';
        if (!empty($expiringMedicines)) {
            $expiringItems = implode(', ', array_map(function ($med) {
                return $med->name . ' (' . date('M d, Y', strtotime($med->expiry_date)) . ')';
            }, $expiringMedicines));
        }

        // Prepare category data for chart
        $categoryData = [
            'labels' => [],
            'counts' => [],
            'colors' => [
                '#4F46E5',
                '#10B981',
                '#F59E0B',
                '#EF4444',
                '#8B5CF6',
                '#EC4899',
                '#06B6D4',
                '#84CC16',
                '#F97316',
                '#6366F1'
            ]
        ];

        foreach ($categoryDistribution as $index => $category) {
            $categoryData['labels'][] = $category->category;
            $categoryData['counts'][] = $category->count;
        }

        $this->view('pages/pharmacist/dashboard.view', [
            'title' => 'Pharmacist Dashboard',
            'lowStockCount' => $lowStockMedicines['count'],
            'outOfStockCount' => $lowStockMedicines['out_of_stock'],
            'lowStockItems' => $lowStockMedicines['items'],
            'totalMedicines' => $medicineStats->total_medicines,
            'expiringCount' => $medicineStats->expiring_soon,
            'expiringItems' => $expiringItems,
            'expiringMedicines' => $expiringMedicines,
            'medicineUsage' => $medicineUsage,
            'categoryDistribution' => $categoryDistribution,
            'categoryData' => $categoryData,
            'inventoryValue' => $inventoryValue,
            'recentTransactions' => $recentTransactions
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
        error_log('Updating medicine with data: ' . print_r($data, true));

        // Get current medicine data for stock comparison
        $currentMedicine = $this->medicineInventoryModel->getMedicineById($data['medicineId']);

        try {
            // Convert unit price to float with 2 decimal places
            $data['unitPrice'] = number_format((float) $data['unitPrice'], 2, '.', '');
            $updated = $this->medicineInventoryModel->updateMed($data);

            if ($updated) {
                $createTransaction = false;
                $stockDifference = 0;

                // Check if stock level has changed
                if ($currentMedicine && $currentMedicine->stock_level != $data['stockLevel']) {
                    $stockDifference = $data['stockLevel'] - $currentMedicine->stock_level;
                    $createTransaction = true;

                    // Create medicine log for stock change
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

                // Check if unit price has changed or if stock has changed
                if ($createTransaction || ($currentMedicine && $currentMedicine->unit_price != $data['unitPrice'])) {
                    // Create transaction record
                    $transactionData = [
                        'medicine_id' => $data['medicineId'],
                        'transaction_type' => 'adjustment',
                        'quantity' => $data['stockLevel'], // Use actual stock level
                        'unit_price' => (float) $data['unitPrice'],
                        'total_amount' => $data['stockLevel'] * (float) $data['unitPrice'],
                        'transaction_date' => date('Y-m-d H:i:s'),
                        'staff_id' => $_SESSION['staff_id'] ?? null,
                        'supplier' => $data['supplier'],
                        'manufacturer' => $data['manufacturer'],
                        'payment_status' => 'completed',
                        'remarks' => $stockDifference != 0 ? 'Stock update - Adjustment' : 'Price update - Adjustment',
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    error_log('Creating transaction record: ' . print_r($transactionData, true));
                    $transactionCreated = $this->transactionRecordModel->createTransaction($transactionData);

                    if (!$transactionCreated) {
                        error_log('Failed to create transaction record');
                    }
                }

                $this->jsonResponse(['success' => true, 'message' => 'Medicine updated successfully']);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to update medicine']);
            }
        } catch (\Exception $e) {
            error_log('Exception while updating medicine: ' . $e->getMessage());
            error_log('Stack trace: ' . $e->getTraceAsString());
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

        // Get top 10 medicines for stock chart (instead of all medicines)
        $topMedicines = $this->medicineInventoryModel->getTopMedicinesByStock(10);
        $stockStats = (object) [
            'labels' => [],
            'current' => [],
            'minimum' => []
        ];

        foreach ($topMedicines as $medicine) {
            $stockStats->labels[] = $medicine->name;
            $stockStats->current[] = $medicine->stock_level;
            // Calculate minimum threshold based on medicine category or use default
            $stockStats->minimum[] = $medicine->min_stock_level ?? 10;
        }

        // Get monthly usage statistics for the current year
        $monthlyUsage = $this->medicineInventoryModel->getMonthlyUsageStats();
        $usageStats = (object) [
            'months' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'dispensed' => array_fill(0, 12, 0),
            'restocked' => array_fill(0, 12, 0)
        ];

        // Fill in the actual data from database
        foreach ($monthlyUsage as $usage) {
            $monthIndex = $usage->month - 1; // Convert 1-based month to 0-based index
            $usageStats->dispensed[$monthIndex] = $usage->dispensed;
            $usageStats->restocked[$monthIndex] = $usage->restocked;
        }

        // Get expiry statistics with clearer time periods
        $expiryStats = (object) [
            'periods' => ['This Week', 'Next Week', 'This Month', 'Next Month', '3 Months'],
            'counts' => [
                count($this->medicineInventoryModel->getExpiringSoonMedicines(7)),
                count($this->medicineInventoryModel->getExpiringSoonMedicines(14)) - count($this->medicineInventoryModel->getExpiringSoonMedicines(7)),
                count($this->medicineInventoryModel->getExpiringSoonMedicines(30)) - count($this->medicineInventoryModel->getExpiringSoonMedicines(14)),
                count($this->medicineInventoryModel->getExpiringSoonMedicines(60)) - count($this->medicineInventoryModel->getExpiringSoonMedicines(30)),
                count($this->medicineInventoryModel->getExpiringSoonMedicines(90)) - count($this->medicineInventoryModel->getExpiringSoonMedicines(60))
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
            'unit_price' => $data['unitPrice'] ?? 0.00,
            'manufacturer' => $data['manufacturer'],
            // 'selling_price' => $data['sellingPrice'] ?? 0.00
        ];

        try {
            // Log the data being inserted
            error_log('Attempting to insert medicine data: ' . print_r($medicineData, true));

            $medicineId = $this->medicineInventoryModel->insert($medicineData);

            if ($medicineId) {
                // Create transaction record for initial stock
                $transactionData = [
                    'medicine_id' => $medicineId,
                    'transaction_type' => 'purchase',
                    'quantity' => $medicineData['stock_level'],
                    'unit_price' => $medicineData['unit_price'],
                    'total_amount' => $medicineData['stock_level'] * $medicineData['unit_price'],
                    'staff_id' => $_SESSION['staff_id'] ?? null,
                    'supplier' => $medicineData['supplier'],
                    'payment_status' => 'completed',
                    'remarks' => 'Initial stock purchase'
                ];

                $this->transactionRecordModel->createTransaction($transactionData);

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


    public function dispenseMedicine()
    {
        if (!$this->isAjaxRequest()) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid request method']);
        }

        $data = $this->getJsonRequestData();

        // Get current medicine data
        $currentMedicine = $this->medicineInventoryModel->getMedicineById($data['medicineId']);

        if (!$currentMedicine) {
            $this->jsonResponse(['success' => false, 'message' => 'Medicine not found']);
        }

        try {
            // Calculate new stock level
            $newStockLevel = $currentMedicine->stock_level - $data['quantity'];

            if ($newStockLevel < 0) {
                $this->jsonResponse(['success' => false, 'message' => 'Insufficient stock']);
            }

            // Update stock level
            $updated = $this->medicineInventoryModel->updateStock($data['medicineId'], $newStockLevel);

            if ($updated) {
                // Create medicine log
                $logData = [
                    'medicine_id' => $data['medicineId'],
                    'action_type' => 'dispense',
                    'quantity' => $data['quantity'],
                    'previous_stock' => $currentMedicine->stock_level,
                    'new_stock' => $newStockLevel,
                    'staff_id' => $_SESSION['staff_id'] ?? null,
                    'doctor_id' => null,
                    'patient_id' => null,
                    'remarks' => $data['remarks'] ?? 'Medicine dispensed'
                ];
                $this->medicineLogsModel->insert($logData);

                // Create transaction record
                $transactionData = [
                    'medicine_id' => $data['medicineId'],
                    'transaction_type' => 'dispense',
                    'quantity' => $data['quantity'],
                    'unit_price' => $currentMedicine->unit_price,
                    'total_amount' => $data['quantity'] * $currentMedicine->unit_price,
                    'transaction_date' => date('Y-m-d H:i:s'),
                    'staff_id' => $_SESSION['staff_id'] ?? null,
                    'supplier' => $currentMedicine->supplier,
                    'manufacturer' => $currentMedicine->manufacturer,
                    'payment_status' => 'completed',
                    'notes' => $data['remarks'] ?? 'Medicine dispensed',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->transactionRecordModel->createTransaction($transactionData);

                $this->jsonResponse(['success' => true, 'message' => 'Medicine dispensed successfully']);
            } else {
                $this->jsonResponse(['success' => false, 'message' => 'Failed to dispense medicine']);
            }
        } catch (\Exception $e) {
            error_log('Exception while dispensing medicine: ' . $e->getMessage());
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