<?php

namespace app\controllers;
use app\models\PatientMonitoringLog;
use app\models\PatientWellnessResponse;

class PatientController extends Controller
{
    private $patientMonitoringLogModel;
    private $patientWellnessResponseModel;
    private $medicationModel;
    private $notificationModel;
    private $achievementModel;
    private $appointmentModel;

    public function __construct()
    {
        $this->patientMonitoringLogModel = new PatientMonitoringLog();
        $this->patientWellnessResponseModel = new PatientWellnessResponse();
    }

    // Update the dashboard method to use our new model methods

    public function dashboard()
    {
        // Get patient ID from session
        $patient_id = $_SESSION['user_id'] ?? null;

        if (!$patient_id) {
            // Redirect to login if not logged in
            $this->redirect('/login');
            return;
        }

        // Initialize models if not already done
        if (!isset($this->medicationModel)) {
            $this->medicationModel = new \app\models\MedicationLog();
        }

        if (!isset($this->notificationModel)) {
            $this->notificationModel = new \app\models\Notification();
        }

        if (!isset($this->achievementModel)) {
            $this->achievementModel = new \app\models\Achievement();
        }

        if (!isset($this->appointmentModel)) {
            $this->appointmentModel = new \app\models\Appointment();
        }

        // Get monitoring logs and symptom chart data
        $monitoring_logs = $this->patientMonitoringLogModel->getRecentLogs($patient_id, 7);
        $symptom_chart_data = $this->patientMonitoringLogModel->getSymptomChartData($patient_id, 7);

        // Get quick stats
        $quick_stats = $this->patientMonitoringLogModel->getQuickStats($patient_id);

        // Get wellness data
        $wellness_data = $this->patientWellnessResponseModel->getWellnessSurveyData($patient_id);

        // Get medication logs
        $medication_logs = $this->medicationModel->getRecentLogs($patient_id);

        // Get upcoming appointments
        $appointments = $this->appointmentModel->getUpcoming($patient_id);

        // Get notifications
        $notifications = $this->notificationModel->getRecent($patient_id);

        // Get achievements
        $achievements = $this->achievementModel->getPatientAchievements($patient_id);

        // Render dashboard with data
        $this->view('pages/patient/dashboard', [
            'title' => 'Patient Dashboard',
            'patient_name' => $_SESSION['user_name'] ?? 'Patient',
            'monitoring_logs' => $monitoring_logs,
            'symptom_chart_data' => $symptom_chart_data,
            'quick_stats' => $quick_stats,
            'wellness_data' => $wellness_data,
            'medication_logs' => $medication_logs,
            'appointments' => $appointments,
            'notifications' => $notifications,
            'achievements' => $achievements
        ]);
    }
}
