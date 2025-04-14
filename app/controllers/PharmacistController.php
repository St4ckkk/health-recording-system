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



}