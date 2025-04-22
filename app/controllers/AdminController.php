<?php

namespace app\controllers;

use app\core\Validator;
use app\models\Staff;
use app\models\Doctor;
use app\models\MedicineLogs;
use app\models\BillingRecords;
use app\models\MedicalRecords;
use app\models\TransactionRecord;
use app\models\MedicineInventory;
use app\models\Patient;
use app\models\Appointment;

class AdminController extends Controller
{
    private $staffModel;
    private $doctorModel;
    private $medicineLogsModel;
    private $billingRecordsModel;
    private $medicalRecordsModel;
    private $transactionRecordModel;
    private $medicineInventoryModel;
    private $patientModel;
    private $appointmentModel;
    private $validator;

    public function __construct()
    {
        $this->staffModel = new Staff();
        $this->doctorModel = new Doctor();
        $this->medicineLogsModel = new MedicineLogs();
        $this->billingRecordsModel = new BillingRecords();
        $this->medicalRecordsModel = new MedicalRecords();
        $this->transactionRecordModel = new TransactionRecord();
        $this->medicineInventoryModel = new MedicineInventory();
        $this->patientModel = new Patient();
        $this->appointmentModel = new Appointment();
        $this->validator = new Validator($_POST);
    }

    public function dashboard()
    {
        // Get staff count
        $staffList = $this->staffModel->getAllStaff();
        $totalStaff = count($staffList);
        $staffByRole = $this->staffModel->getStaffCountByRole();

        // Get doctor count
        $totalDoctors = $this->doctorModel->getTotalDoctorCount();
        $doctorsBySpecialization = $this->doctorModel->getDoctorCountBySpecialization();

        // Get transaction stats
        $transactionStats = $this->transactionRecordModel->getTransactionStats();
        $recentTransactions = $this->transactionRecordModel->getRecentTransactions(5);

        // Get billing stats
        $billingStats = $this->billingRecordsModel->getBillingStats();
        $recentBillings = $this->billingRecordsModel->getRecentBillings(5);

        // Get medicine logs
        $recentMedicineLogs = $this->medicineLogsModel->getMedicineLogs();

        // Get medical records stats
        $medicalRecordsStats = $this->medicalRecordsModel->getMedicalRecordsStats();
        $recentMedicalRecords = $this->medicalRecordsModel->getRecentMedicalRecords(5);

        // Get medicine inventory stats
        $inventoryStats = $this->medicineInventoryModel->getInventoryStats();
        $totalMedicines = $this->medicineInventoryModel->getTotalMedicinesCount();
        $inventoryValue = $this->medicineInventoryModel->getTotalInventoryValue();
        $lowStockMedicines = $this->medicineInventoryModel->getLowStockCount();
        $lowStockCount = $lowStockMedicines['count'];
        $lowStockItems = $lowStockMedicines['items'];

        // Prepare data for charts
        $staffRoleData = [
            'labels' => array_column($staffByRole, 'role_name'),
            'counts' => array_column($staffByRole, 'count'),
            'colors' => $this->generateChartColors(count($staffByRole))
        ];

        $doctorSpecializationData = [
            'labels' => array_column($doctorsBySpecialization, 'specialization'),
            'counts' => array_column($doctorsBySpecialization, 'count'),
            'colors' => $this->generateChartColors(count($doctorsBySpecialization))
        ];

        $this->view('pages/admin/dashboard.view', [
            'title' => 'Admin Dashboard',
            'totalStaff' => $totalStaff,
            'totalDoctors' => $totalDoctors,
            'transactionStats' => $transactionStats,
            'billingStats' => $billingStats,
            'recentTransactions' => $recentTransactions,
            'recentBillings' => $recentBillings,
            'recentMedicineLogs' => $recentMedicineLogs,
            'medicalRecordsStats' => $medicalRecordsStats,
            'recentMedicalRecords' => $recentMedicalRecords,
            'staffRoleData' => $staffRoleData,
            'doctorSpecializationData' => $doctorSpecializationData,
            'totalMedicines' => $totalMedicines,
            'inventoryValue' => $inventoryValue,
            'lowStockCount' => $lowStockCount,
            'lowStockItems' => $lowStockItems
        ]);
    }

    private function generateChartColors($count)
    {
        $colors = [
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 99, 132, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 205, 86, 0.7)',
            'rgba(201, 203, 207, 0.7)',
            'rgba(255, 99, 71, 0.7)',
            'rgba(50, 205, 50, 0.7)',
            'rgba(138, 43, 226, 0.7)'
        ];

        // If we need more colors than available, repeat the array
        if ($count > count($colors)) {
            $colors = array_merge($colors, $colors);
        }

        return array_slice($colors, 0, $count);
    }

    public function staffManagement()
    {
        $staffList = $this->staffModel->getAllStaff();
        $roles = $this->staffModel->getAllRoles();

        $this->view('pages/admin/staff-management.view', [
            'title' => 'Staff Management',
            'staffList' => $staffList,
            'roles' => $roles
        ]);
    }

    public function addStaff()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Debug received data
                error_log("POST data received: " . json_encode($_POST));

                // Extract and validate form data
                $staffData = [
                    'first_name' => $_POST['firstName'] ?? '',
                    'last_name' => $_POST['lastName'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'password' => $_POST['password'] ?? '',
                    'phone' => $_POST['phone'] ?? '',
                    'role_id' => $_POST['roleId'] ?? '',
                ];

                // Validate required fields
                $validator = new Validator($_POST);
                $validator->required(['firstName', 'lastName', 'email', 'password', 'roleId'])
                    ->email('email');

                if ($validator->fails()) {
                    error_log("Validation failed: " . $validator->getFirstError());
                    echo json_encode([
                        'success' => false,
                        'message' => $validator->getFirstError()
                    ]);
                    return;
                }

                // Handle profile image upload
                $profileImage = null;
                if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
                    $profileImage = $this->handleStaffProfileImage();
                    if (is_array($profileImage) && isset($profileImage['error'])) {
                        echo json_encode([
                            'success' => false,
                            'message' => $profileImage['error']
                        ]);
                        return;
                    }
                }

                // Generate a staff ID if not provided
                $staffId = 'STF' . date('Ymd') . rand(1000, 9999);

                // Hash the password
                $password = hash('sha256', $staffData['password']);

                // Prepare data for database
                $dbData = [
                    'staff_id' => $staffId,
                    'first_name' => $staffData['first_name'],
                    'last_name' => $staffData['last_name'],
                    'email' => $staffData['email'],
                    'password' => $password,
                    'phone' => $staffData['phone'],
                    'profile' => $profileImage,
                    'role_id' => $staffData['role_id'],
                    'created_at' => date('Y-m-d H:i:s')
                ];

                // Insert into database
                $result = $this->staffModel->insert($dbData);

                if ($result) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Staff member added successfully',
                        'staffId' => $result
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to add staff member. Database error.'
                    ]);
                }
            } catch (\Exception $e) {
                error_log('Error in addStaff: ' . $e->getMessage());
                echo json_encode([
                    'success' => false,
                    'message' => 'Server error: ' . $e->getMessage()
                ]);
            }
            exit;
        }
    }

    /**
     * Handle staff profile image upload
     * 
     * @return string|array The profile image path or error array
     */
    private function handleStaffProfileImage()
    {
        if (!isset($_FILES['profilePicture']) || $_FILES['profilePicture']['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Validate file
        $fileValidator = new Validator(['profilePicture' => $_FILES['profilePicture']]);
        $fileValidator->fileSize('profilePicture', 2 * 1024 * 1024, 'Profile image must not exceed 2MB')
            ->fileType('profilePicture', ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'], 'Only JPG, PNG and GIF files are allowed');

        if ($fileValidator->fails()) {
            return ['error' => $fileValidator->getFirstError()];
        }

        // Define uploads directory
        $uploadsDir = dirname(APP_ROOT) . '/public/uploads/staff';

        // Create directory if it doesn't exist
        if (!file_exists($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }

        // Generate unique filename
        $filename = uniqid() . '_' . time() . '_' . str_replace(' ', '_', $_FILES['profilePicture']['name']);
        $destination = $uploadsDir . '/' . $filename;

        // Move uploaded file
        if (!move_uploaded_file($_FILES['profilePicture']['tmp_name'], $destination)) {
            return ['error' => 'Failed to upload file'];
        }

        // Return the relative path for database storage
        return 'uploads/staff/' . $filename;
    }

    public function deleteStaff()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $staffId = $data['staffId'] ?? null;

            if ($staffId) {
                $result = $this->staffModel->delete($staffId);

                if ($result) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Staff member deleted successfully'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to delete staff member'
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid staff ID'
                ]);
            }
            exit;
        }
    }

    public function doctorManagement()
    {
        $doctorList = $this->doctorModel->getAllDoctors();

        $this->view('pages/admin/doctor-management', [
            'title' => 'Doctor Management',
            'doctorList' => $doctorList
        ]);
    }

    public function medicineInventory()
    {
        $medicines = $this->medicineInventoryModel->getAllMedicines();
        $categories = $this->medicineInventoryModel->getAllMedicineCategories();

        $this->view('pages/admin/medicine-inventory', [
            'title' => 'Medicine Inventory',
            'medicines' => $medicines,
            'categories' => $categories
        ]);
    }

    public function medicineLogs()
    {
        $medicineLogs = $this->medicineLogsModel->getMedicineLogs();

        $this->view('pages/admin/medicine-logs', [
            'title' => 'Medicine Logs',
            'medicineLogs' => $medicineLogs
        ]);
    }

    public function billingRecords()
    {
        $billingRecords = $this->billingRecordsModel->getAllBillingRecords();

        $this->view('pages/admin/billing.view', [
            'title' => 'Billing Records',
            'billingRecords' => $billingRecords
        ]);
    }

    public function medicalRecords()
    {
        $medicalRecords = $this->medicalRecordsModel->getAllMedicalRecords();

        $this->view('pages/admin/medical-records', [
            'title' => 'Medical Records',
            'medicalRecords' => $medicalRecords
        ]);
    }

    public function patientManagement()
    {
        $patients = $this->patientModel->getAllPatients();

        $this->view('pages/admin/patient-management', [
            'title' => 'Patient Management',
            'patients' => $patients
        ]);
    }

    public function appointmentManagement()
    {
        $appointments = $this->appointmentModel->getAllAppointments();
        $doctors = $this->doctorModel->getAllDoctors();

        $this->view('pages/admin/appointment-management', [
            'title' => 'Appointment Management',
            'appointments' => $appointments,
            'doctors' => $doctors
        ]);
    }

    public function reports()
    {
        // Get system-wide statistics
        $staffStats = $this->staffModel->getStaffStats();
        $doctorStats = $this->doctorModel->getDoctorStats();
        $patientStats = $this->patientModel->getPatientStats();
        $appointmentStats = $this->appointmentModel->getAppointmentStats();
        $medicineStats = $this->medicineInventoryModel->getMedicineStats();
        $billingStats = $this->billingRecordsModel->getBillingStats();
        $transactionStats = $this->transactionRecordModel->getTransactionStats();

        $this->view('pages/admin/reports', [
            'title' => 'System Reports',
            'staffStats' => $staffStats,
            'doctorStats' => $doctorStats,
            'patientStats' => $patientStats,
            'appointmentStats' => $appointmentStats,
            'medicineStats' => $medicineStats,
            'billingStats' => $billingStats,
            'transactionStats' => $transactionStats
        ]);
    }


    public function transactionRecords()
    {
        $transactionRecords = $this->transactionRecordModel->getAllTransactionRecords();

        $this->view('pages/admin/transaction.view', [
            'title' => 'Transaction Records',
            'transactionRecords' => $transactionRecords
        ]);
    }

    public function systemSettings()
    {
        // Get current system settings
        // Implementation depends on how settings are stored

        $this->view('pages/admin/system-settings', [
            'title' => 'System Settings'
            // Add settings data here
        ]);
    }

    public function saveSystemSettings()
    {
        // Process and save system settings
        // Implementation depends on how settings are stored

        // Redirect back to settings page with success message
        $this->redirect('/admin/system-settings?success=1');
    }
}